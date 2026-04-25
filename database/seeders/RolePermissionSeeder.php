<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // daftar permission (sesuaikan dengan resource kamu)
        $permissions = [
            'view customer',
            'create customer',
            'edit customer',
            'delete customer',

            'view kategori',
            'create kategori',
            'edit kategori',
            'delete kategori',

            'view order',
            'create order',
            'edit order',
            'delete order',

            'view produk',
            'create produk',
            'edit produk',
            'delete produk',

            'view satuan',
            'create satuan',
            'edit satuan',
            'delete satuan',

            'view supplier',
            'create supplier',
            'edit supplier',
            'delete supplier',

            'view user',
            'create user',
            'edit user',
            'delete user',

            'view role',
            'create role',
            'edit role',
            'delete role',

            'view permission',
            'create permission',
            'edit permission',
            'delete permission',


        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $kasir = Role::firstOrCreate(['name' => 'kasir']);

        // assign permission
        $admin->syncPermissions($permissions);

        $kasir->syncPermissions([
            'view produk',
            'view order',
            'create order',
            'edit order',
            'view customer',
            'create customer',
            'edit customer',
        ]);
    }
}