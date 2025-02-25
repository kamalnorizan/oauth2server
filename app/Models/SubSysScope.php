<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSysScope extends Model
{
    public $timestamps = true;

    protected $table = 'sub_sys_scopes';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function subSystem()
    {
        return $this->belongsTo(SubSystem::class, 'sub_system_id', 'id');
    }
}
