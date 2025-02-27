<?php

namespace App\Models;

use Laravel\Passport\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubSystem extends Model
{
    public $timestamps = true;

    protected $table = 'sub_systems';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'uuid';

    }


    public function scopes(): HasMany
    {
        return $this->hasMany(SubSysScope::class, 'sub_system_id', 'id');
    }

    /**
     * Get the client that owns the SubSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
