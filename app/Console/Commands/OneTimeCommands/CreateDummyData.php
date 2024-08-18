<?php

namespace App\Console\Commands\OneTimeCommands;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CreateDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'one-time:create-dummy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates roles, admin user and random users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createPermissions();
        $this->createRoles();
        $this->createRandomUsers();
        $this->createAdminUser();
    }

    private function createPermissions(): void
    {
        $permissionNames = [
            'Create User',
            'Edit User',
            'Delete User',
            'Create Role',
            'Edit Role',
            'Delete Role',
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
        ];

        foreach ($permissionNames as $permissionName) {
            Permission::create([
                'name' => $permissionName,
                'is_active' => true,
            ]);
        }
    }

    private function createRoles()
    {
        $roleNames = [
            'Technical Administrator',
            'User and Subscription Administrator',
            'Questions/Answers Administrator',
            'Content Administrator',
            'Legal Administrator',
            'Newsletter Administrator',
        ];

        foreach ($roleNames as $roleName) {
            $role = Role::create([
                'name' => $roleName,
                'is_active' => true,
            ]);

            if (in_array($role->name, Arr::take($roleNames, 2))) {
                $role->permissions()->sync(Permission::all()->pluck('id')->toArray());
            }
        }
    }

    private function createRandomUsers()
    {
        $count = $this->ask('How many users should be created? Default:', 100);

        $users = User::factory()->count($count)->create();

        foreach ($users as $user) {
            $randomCount = rand(0, 6);
            $randomRoles = Arr::random(Role::pluck('id')->toArray(), $randomCount);
            $user->roles()->sync($randomRoles);
        }
    }

    private function createAdminUser()
    {
        $username = $this->ask('Please provide username for admin user. Default:', 'admin');
        $password = $this->ask('Please provide password for admin user. Default:', 'admin');

        $user = User::create([
            'name' => 'admin',
            'username' => $username,
            'is_active' => true,
            'email_verified_at' => now(),
            'email' => 'demo@admin.com',
            'password' => $password,
        ]);

        $roles = Role::get()->pluck('id')->toArray();
        $user->roles()->sync($roles);
    }
}
