<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubSystem extends Model
{
    public $timestamps = true;

    protected $table = 'user_sub_systems';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    /**
     * Get the user that owns the UserSubSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the subSystem that owns the UserSubSystem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsystem(): BelongsTo
    {
        return $this->belongsTo(SubSystem::class, 'sub_system_id', 'id');
    }
}
