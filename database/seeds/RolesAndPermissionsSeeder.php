<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        $permissions = [
            'add_inventory',
            'edit_inventory',
            'delete_inventory',
            'view_inventory',
            'approve_inventory'
        ];
        
        $roles = [
            'store_manager',
            'store_assistant'
        ];
        app()['cache']->forget('spatie.permission.cache');
        foreach ($permissions as $permission){
            try{
                Permission::create(['name' => $permission]);

                echo "Permission $permission created \n";
            } catch (PermissionAlreadyExists $e){
                echo $e->getMessage(); echo "\n";
                continue;
            }
        }
        foreach ($roles as $roleName){
            try{
                $role = Role::create(['name' => $roleName]);
                if($roleName === 'store_mananger'){
                    $role->givePermissionTo(Permission::all());
                } else {
                    $role->givePermissionTo('view_inventory');
                }
                echo "Role $roleName created \n";
            } catch (RoleAlreadyExists $e){
                echo $e->getMessage(); 
                echo "\n";
            }
        }
        
        app()['cache']->forget('spatie.permission.cache');

    }
}
