<?php

namespace App\Models;

use App\Components\Filters\QueryFilters;
use App\Models\ACL\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $appends = ['last_updated'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            try{
                if (!Schema::hasColumn($model->getTable(), 'created_by')) {
                    Schema::table($model->getTable(), function (Blueprint $table) {
                        $table->unsignedBigInteger('created_by')->nullable();
                        $table->foreign('created_by')->references('id')->on('users');
                    });
                }
            }catch(\Exception $ex){

            }
            
            if(@\Auth::user()) $model['created_by'] = @\Auth::user()->id;
        });

        static::saving(function($model) {
            try{
                if (!Schema::hasColumn($model->getTable(), 'updated_by')) {
                    Schema::table($model->getTable(), function (Blueprint $table) {
                        $table->unsignedBigInteger('updated_by')->nullable();
                        $table->foreign('updated_by')->references('id')->on('users');
                    });
                }
            }catch(\Exception){

            }
            
            if(@\Auth::user()) $model['updated_by'] = @\Auth::user()->id;
        });
    }

    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

    public function scopeSetJoin($query, $joinTable = '', $originId = '', $joinId = 'id')
    {
        if($originId == ''){
            if(str_contains($joinTable, 'ies') || str_contains($joinTable, 'ys')){
                $originId = substr(str_replace('ies', 'ys', $joinTable), 0, -1).'_id';
            }else{
                $originId = $joinTable.'_id';
            }
        } 

        return $query->join($joinTable, $joinTable.'.'.$joinId, $query->getQuery()->from.'.'.$originId);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getLastUpdatedAttribute()
    {
        return Carbon::parse($this->updated_at)->format('F d, Y H:i:s');
    }
}
