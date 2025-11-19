<?php

namespace App\Models;

use App\Traits\TracksUserActions;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use TracksUserActions;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    function scopeDataSearch($query, $data): Builder
    {
        return $query->where(function ($q) use ($data) {
            if (!empty($data['search_data'])) {
                $q->where('name', 'like', '%' . $data['search_data'] . '%');
            }
            if (!empty($data['is_active'])) {
                $q->where('is_active', $data['is_active'] == 1 ? true : false);
            }
        });
    }
}
