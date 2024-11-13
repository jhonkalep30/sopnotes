<?php

namespace App\Imports\ACL\Users;

use App\Models\ACL\Role;
use App\Models\ACL\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Row;

class UserImport implements OnEachRow, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        $user = null;
        if($row['role'] != null){
            $role = Role::where('name',$row['role'])->first();

            if($role){
                
                if($user = User::whereEmail($row['email'])->first()){
                    $user->update([
                        'name' => $row['name'],
                        'role_id' => $role->id,
                    ]);

                    // UPDATE PASSWORD IF FILLED
                    if($row['password']) $user->update(['password' => bcrypt($row['password'])]);
                }else{
                    User::create([
                        'email' => $row['email'],
                        'name' => $row['name'],
                        'password' => bcrypt($row['password']),
                        'role_id' => $role->id,
                    ]);
                }

            }else{
                throw new \Exception('Role "'.$row['role'].'" not found on row: '.$rowIndex, 1);
            }
        }else{
            throw new \Exception('Role can\'t be null on row: '.$rowIndex, 1);
        }
    }

    public function sheets(): array
    {
        return [
            'Data' => $this,
        ];
    }
}