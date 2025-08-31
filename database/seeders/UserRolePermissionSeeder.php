<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view vendor']);
        Permission::create(['name' => 'create vendor']);
        Permission::create(['name' => 'update vendor']);
        Permission::create(['name' => 'delete vendor']);

        Permission::create(['name' => 'view archived user']);
        Permission::create(['name' => 'create archived user']);
        Permission::create(['name' => 'update archived user']);
        Permission::create(['name' => 'delete archived user']);

        Permission::create(['name' => 'view setting']);
        Permission::create(['name' => 'create setting']);
        Permission::create(['name' => 'update setting']);
        Permission::create(['name' => 'delete setting']);

        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'update product']);
        Permission::create(['name' => 'delete product']);

        Permission::create(['name' => 'view order']);
        Permission::create(['name' => 'create order']);
        Permission::create(['name' => 'update order']);
        Permission::create(['name' => 'delete order']);

        Permission::create(['name' => 'view warehouse']);
        Permission::create(['name' => 'create warehouse']);
        Permission::create(['name' => 'update warehouse']);
        Permission::create(['name' => 'delete warehouse']);

        Permission::create(['name' => 'view wallet']);
        Permission::create(['name' => 'create wallet']);
        Permission::create(['name' => 'update wallet']);
        Permission::create(['name' => 'delete wallet']);

        Permission::create(['name' => 'view withdraw']);
        Permission::create(['name' => 'create withdraw']);
        Permission::create(['name' => 'update withdraw']);
        Permission::create(['name' => 'delete withdraw']);


        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);
        $vendorRole = Role::create(['name' => 'vendor']);

        // give all permissions to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // give permissions to admin role.
        $adminRole->givePermissionTo(['view role']);
        $adminRole->givePermissionTo(['view permission']);
        $adminRole->givePermissionTo(['create user', 'view user', 'update user']);

        // give permissions to vendor role.
        $vendorRole->givePermissionTo(['view product']);
        $vendorRole->givePermissionTo(['view order']);
        $vendorRole->givePermissionTo(['view warehouse', 'create warehouse', 'update warehouse', 'delete warehouse']);
        $vendorRole->givePermissionTo(['view wallet', 'create wallet', 'update wallet', 'delete wallet']);
        $vendorRole->givePermissionTo(['view withdraw', 'create withdraw', 'update withdraw', 'delete withdraw']);


        // Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
                    'email' => 'superadmin@gmail.com',
                ], [
                    'name' => 'Super Admin',
                    'email' => 'superadmin@gmail.com',
                    'username' => 'superadmin',
                    'password' => Hash::make ('superadmin@gmail.com'),
                    'email_verified_at' => now(),
                ]);

        $superAdminUser->assignRole($superAdminRole);

        $superAdminProfile = $superAdminUser->profile()->firstOrCreate([
            'user_id' => $superAdminUser->id,
        ], [
            'user_id' => $superAdminUser->id,
            'first_name' => $superAdminUser->name,
        ]);

        $superAdminBankDetails = $superAdminUser->userBankDetail()->firstOrCreate([
            'user_id' => $superAdminUser->id,
        ], [
            'user_id' => $superAdminUser->id,
        ]);

        $superAdminShopDetails = $superAdminUser->userShop()->firstOrCreate([
            'user_id' => $superAdminUser->id,
        ], [
            'user_id' => $superAdminUser->id,
        ]);
    }
}
