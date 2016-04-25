<?php
/**
 * Author: Xavier Au
 * Date: 12/2/16
 * Time: 5:57 PM
 */

namespace App\Services;


use App\User;
use Illuminate\Http\Request;

class UserServices
{
    public function createUserAndAssignRoles(Request $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();
        $user->roles()->sync($request->get('role'));
        return $user;
    }
    public function updateUserAndRoles(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if($request->get('password')) $user->password = bcrypt($request->get('password'));
        $user->save();

        $user->roles()->sync($request->get('role'));
        return $user;
    }
    public function deleteUser($userId)
    {
        $user = $users = User::findOrFail($userId);
        $user->delete();
        return $user;
    }
}