<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubSystem extends Model
{
    public $timestamps = true;

    protected $table = 'sub_systems';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get all of the scopes for the SubSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scopes(): HasMany
    {
        return $this->hasMany(SubSysScope::class, 'sub_system_id', 'id');
    }
}
