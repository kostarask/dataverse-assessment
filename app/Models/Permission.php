<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    public const CAN_CREATE_USER = 'Create User';
    public const CAN_EDIT_USER = 'Edit User';
    public const CAN_DELETE_USER = 'Delete User';
    public const CAN_CREATE_ROLE = 'Create Role';
    public const CAN_EDIT_ROLE = 'Edit Role';
    public const CAN_DELETE_ROLE = 'Delete Role';
    public const CAN_CREATE_PERMISSION = 'Create Permission';
    public const CAN_EDIT_PERMISSION = 'Edit Permission';
    public const CAN_DELETE_PERMISSION = 'Delete Permission';
    protected $guarded = [
        'id'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
