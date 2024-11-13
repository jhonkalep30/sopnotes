<?php

namespace App\Models\ACL;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Components\Filters\QueryFilters;
use App\Models\ACL\Menu;
use App\Models\ACL\Role;
use App\Models\ACL\RolePermission;
use App\Models\ACL\User;
use App\Models\Reference\Direktorat;
use App\Models\Reference\Jabatan;
use App\Models\Reference\Kota;
use App\Models\Reference\Outlet;
use App\Models\Reference\UnitBisnis;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'photo_url',
        'active',
        'direktorat_id', 'unit_bisnis_id', 'kota_id', 'outlet_id', 'jabatan_id',
        'jenis_kelamin',
        'status',
        'npp',
        'id_his',
        'plt_penugasan',
        'tmb_plt',
        'masa_kerja_plt',
        'cost_center',
        'outlet_inhouse',
        'strata_unit_bisnis',
        'kelas_outlet',
        'pendidikan',
        'jurusan',
        'alumni_pendidikan',
        'tanggal_lulus',
        'gelar_profesi',
        'alumni_pendidikan_profesi',
        'tahun_lulus_profesi',
        'tempat_lahir',
        'tanggal_lahir',
        'tmb',
        'masa_kerja',
        'tmb_jabatan_saat_ini',
        'masa_kerja_jabatan_saat_ini',
        'tmb_kenaikan_level',
        'tanggal_pj_penuh',
        'tmb_pt',
        'masa_kerja_pt',
        'grading',
        'eselon',
        'spk_i',
        'spk_ii',
        'spk_iii',
        'spk_iv',
        'spk_v',
        'habis_kontrak',
        'domisili_asal',
        'alamat_ktp',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'agama',
        'ktp',
        'no_tlp',
        'alamat_email',
        'no_tlp_keluarga',
        'alamat_sesuai_npwp',
        'npwp',
        'nama_ibu',
        'nama_ayah',
        'bpjs_kes',
        'no_rek',
        'status_kawin_npwp',
        'golongan_darah',
        'status_kawin',
        'jml_anak',
        'jml_anggota_keluarga',
        'nama_pasangan',
        'anak_1',
        'anak_2',
        'anak_3',
        'anak_4',
        'anak_5'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token)
    {
        $data = [
            $this->email
        ];

        Mail::send('email.reset-password', [
            'name'      => $this->name,
            'url'     => route('password.reset', ['token' => $token, 'email' => $this->email]),
        ], function($message) use($data){
            $message->subject('Reset Password Request');
            $message->to($data[0]);
        });
    }

    public function rule()
    {
        return [
            'name' => 'required|string',
            'email' => 'nullable|email',
            'role_id' => 'required|integer|exists:roles,id',
            'password' => 'required|string',
            'active' => 'nullable|numeric',
            'photo_url' => 'nullable',

            'direktorat_id' => 'nullable|integer|exists:direktorat,id',
            'unit_bisnis_id' => 'nullable|integer|exists:unit_bisnis,id',
            'kota_id' => 'nullable|integer|exists:kota,id',
            'outlet_id' => 'nullable|integer|exists:outlets,id',
            'jabatan_id' => 'required|integer|exists:jabatan,id',

            'jenis_kelamin' => 'required|string',
            'status' => 'nullable|string',

            'npp' => 'required|string|unique:users,npp',

            'id_his' => 'nullable|string',
            'plt_penugasan' => 'nullable|string',
            'tmb_plt' => 'nullable|date',
            'masa_kerja_plt' => 'nullable|string',
            'cost_center' => 'nullable|string',
            'outlet_inhouse' => 'nullable|string',
            'strata_unit_bisnis' => 'nullable|string',
            'kelas_outlet' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'alumni_pendidikan' => 'nullable|string',
            'tanggal_lulus' => 'nullable|string',
            'gelar_profesi' => 'nullable|string',
            'alumni_pendidikan_profesi' => 'nullable|string',
            'tahun_lulus_profesi' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'tmb' => 'nullable|string',
            'masa_kerja' => 'nullable|string',
            'tmb_jabatan_saat_ini' => 'nullable|string',
            'masa_kerja_jabatan_saat_ini' => 'nullable|string',
            'tmb_kenaikan_level' => 'nullable|string',
            'tanggal_pj_penuh' => 'nullable|string',
            'tmb_pt' => 'nullable|string',
            'masa_kerja_pt' => 'nullable|string',
            'grading' => 'nullable|string',
            'eselon' => 'nullable|string',
            'spk_i' => 'nullable|string',
            'spk_ii' => 'nullable|string',
            'spk_iii' => 'nullable|string',
            'spk_iv' => 'nullable|string',
            'spk_v' => 'nullable|string',
            'habis_kontrak' => 'nullable|string',
            'domisili_asal' => 'nullable|string',
            'alamat_ktp' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'agama' => 'nullable|string',
            'ktp' => 'nullable|string',
            'no_tlp' => 'nullable|string',
            'alamat_email' => 'nullable|string',
            'no_tlp_keluarga' => 'nullable|string',
            'alamat_sesuai_npwp' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'bpjs_kes' => 'nullable|string',
            'no_rek' => 'nullable|string',
            'status_kawin_npwp' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'status_kawin' => 'nullable|string',
            'jml_anak' => 'nullable|string',
            'jml_anggota_keluarga' => 'nullable|string',
            'nama_pasangan' => 'nullable|string',
            'anak_1' => 'nullable|string',
            'anak_2' => 'nullable|string',
            'anak_3' => 'nullable|string',
            'anak_4' => 'nullable|string',
            'anak_5' => 'nullable|string',
        ];
    }

    public function ruleOnUpdate()
    {
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'role_id' => 'nullable|integer',
            'password' => 'nullable|string',
            'active' => 'nullable|numeric',
            'photo_url' => 'nullable',

            'direktorat_id' => 'nullable|integer|exists:direktorat,id',
            'unit_bisnis_id' => 'nullable|integer|exists:unit_bisnis,id',
            'kota_id' => 'nullable|integer|exists:kota,id',
            'outlet_id' => 'nullable|integer|exists:outlets,id',
            'jabatan_id' => 'nullable|integer|exists:jabatan,id',

            'jenis_kelamin' => 'nullable|string',
            'status' => 'nullable|string',

            'npp' => 'nullable|string|unique:users,npp,'.$this->id,

            'id_his' => 'nullable|string',
            'plt_penugasan' => 'nullable|string',
            'tmb_plt' => 'nullable|date',
            'masa_kerja_plt' => 'nullable|string',
            'cost_center' => 'nullable|string',
            'outlet_inhouse' => 'nullable|string',
            'strata_unit_bisnis' => 'nullable|string',
            'kelas_outlet' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'alumni_pendidikan' => 'nullable|string',
            'tanggal_lulus' => 'nullable|string',
            'gelar_profesi' => 'nullable|string',
            'alumni_pendidikan_profesi' => 'nullable|string',
            'tahun_lulus_profesi' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'tmb' => 'nullable|string',
            'masa_kerja' => 'nullable|string',
            'tmb_jabatan_saat_ini' => 'nullable|string',
            'masa_kerja_jabatan_saat_ini' => 'nullable|string',
            'tmb_kenaikan_level' => 'nullable|string',
            'tanggal_pj_penuh' => 'nullable|string',
            'tmb_pt' => 'nullable|string',
            'masa_kerja_pt' => 'nullable|string',
            'grading' => 'nullable|string',
            'eselon' => 'nullable|string',
            'spk_i' => 'nullable|string',
            'spk_ii' => 'nullable|string',
            'spk_iii' => 'nullable|string',
            'spk_iv' => 'nullable|string',
            'spk_v' => 'nullable|string',
            'habis_kontrak' => 'nullable|string',
            'domisili_asal' => 'nullable|string',
            'alamat_ktp' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'agama' => 'nullable|string',
            'ktp' => 'nullable|string',
            'no_tlp' => 'nullable|string',
            'alamat_email' => 'nullable|string',
            'no_tlp_keluarga' => 'nullable|string',
            'alamat_sesuai_npwp' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'bpjs_kes' => 'nullable|string',
            'no_rek' => 'nullable|string',
            'status_kawin_npwp' => 'nullable|string',
            'golongan_darah' => 'nullable|string',
            'status_kawin' => 'nullable|string',
            'jml_anak' => 'nullable|string',
            'jml_anggota_keluarga' => 'nullable|string',
            'nama_pasangan' => 'nullable|string',
            'anak_1' => 'nullable|string',
            'anak_2' => 'nullable|string',
            'anak_3' => 'nullable|string',
            'anak_4' => 'nullable|string',
            'anak_5' => 'nullable|string',
        ];
    }

    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id');
    }

    public function kota_link()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'outlet_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function unitBisnis()
    {
        return $this->belongsTo(UnitBisnis::class, 'unit_bisnis_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getMenu()
    {
        $result = [];
        $searching = @$request->search ? true : false;

        // SECTIONS
        $sections = Menu::where('type', 'section')->orderBy('order')->get();
        foreach ($sections as $section) {
            
            $addSection = true;

            // CHECKING PERMISSIONS, SET FALSE IF NOT PERMITTED

            // GROUPS AND OR LINKS
            $groups = Menu::whereIn('type', ['group', 'link'])->where('parent_id', $section->id)->orderBy('order')->get();
            $groupDatas = [];

            foreach ($groups as $group) {
                
                $addGroup = true;

                // CHECKING PERMISSIONS, SET FALSE IF NOT PERMITTED
                if(@$group->permission_id){
                    $addGroup = @RolePermission::wherePermissionId($group->permission_id)->whereRoleId(@\Auth::user()->role_id)->first()->access ? true : false;
                }

                // LINKS
                $links = Menu::where('type', 'link')->where('parent_id', $group->id)->orderBy('order')->get();
                $linkDatas = [];

                foreach ($links as $link) {

                    $addLink = true;

                    // CHECKING PERMISSIONS, SET FALSE IF NOT PERMITTED
                    if(@$link->permission_id){
                        $addLink = @RolePermission::wherePermissionId($link->permission_id)->whereRoleId(@\Auth::user()->role_id)->first()->access ? true : false;
                    }

                    // CHECK MASTER
                    if(master()) $addLink = true;

                    // IS MENU HIDDEN
                    if($link->is_hidden) $addLink = false;

                    if($addLink) $linkDatas[] = $link;
                    if(!$addGroup && $addLink) $addGroup = true;
                }

                if(count($linkDatas) > 0) $group['links'] = $linkDatas;
                if($group->type == 'group' && count($linkDatas) == 0) $addGroup = false;
                if($links->count() > 0 && count($linkDatas) == 0) $addGroup = false;

                // CHECK MASTER
                if(master()) $addGroup = true;

                // IS MENU HIDDEN
                if($group->is_hidden) $addGroup = false;

                if($addGroup) $groupDatas[] = $group;
                if(!$addSection && $addGroup) $addSection = true;
            }

            if(count($groupDatas) > 0){
                $section['groups'] = $groupDatas;
            }else{
                $addSection = false;
            }

            // CHECK MASTER
            if(master()) $addSection = true;

            // IS MENU HIDDEN
            if($section->is_hidden) $addSection = false;

            if($addSection) $result[] = $section;
        }

        // ADD SYSTEM (MASTER MENU)
        if(\Auth::user()->role->is_master){
            $system = [
                'label' => 'System',
                'type' => 'section',
                'groups' => 
                [
                    [
                        'label' => 'Setting',
                        'type' => 'link',
                        'icon' => '<i class="ki-duotone ki-setting-2 text-muted fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>',
                        'url' => 'setting'
                    ],
                    [
                        'label' => 'Menu',
                        'type' => 'link',
                        'icon' => '<i class="ki-duotone ki-data">
                                     <i class="path1"></i>
                                     <i class="path2"></i>
                                     <i class="path3"></i>
                                     <i class="path4"></i>
                                     <i class="path5"></i>
                                    </i>',
                        'url' => 'menu'
                    ],
                    [
                        'label' => 'Permission',
                        'type' => 'link',
                        'icon' => '<i class="ki-duotone ki-shield">
                                     <i class="path1"></i>
                                     <i class="path2"></i>
                                    </i>',
                        'url' => 'permission'
                    ]
                ]
            ];

            $result[] = $system;
        }

        return $result;
    }
}
