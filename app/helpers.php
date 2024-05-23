<?php
namespace App;

use App\Models\User;

class MyHelper {
    public static function checkUserPermission($permission, $id) {
        $user = User::find($id);
        if(!($user->is_admin)) {
            $userPermissions = $user->permissions;
            if (!($userPermissions)) {
                return false;
            }
            $permissions = [];
            foreach($userPermissions as $userPermission) {
                $permissions[] = $userPermission->name;
            }
            return in_array($permission, $permissions);
        }
        return true;
    }
}
