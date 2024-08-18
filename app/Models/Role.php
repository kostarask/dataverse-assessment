<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    public const ADMIN = 'Technical Administrator';
    public const USERc = 'User and Subscription Administrator';
    public const QA_ADMIN = 'Questions/Answers Administrator';
    public const CONTENT_ADMIN = 'Content Administrator';
    public const LEGAL_ADMIN = 'Legal Administrator';
    public const NEWSLETTER_ADMIN = 'Newsletter Administrator';
    public const USER = 'User';
    protected $guarded = [
        'id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

}
