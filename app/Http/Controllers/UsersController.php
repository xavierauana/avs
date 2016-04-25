<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserServices;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('back.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('back.pages.users.create');
    }

    public function store(UserCreateRequest $request, UserServices $services)
    {
        $services->createUserAndAssignRoles($request);
        return redirect('/admin/users');
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        return view('back.pages.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, UserServices $services, $userId)
    {
        $user = $services->updateUserAndRoles($request, $userId);
        if($request->wantsJson()){
            return response()->json(['message'=>'user updated!', 'user'=>$user]);
        }
        return redirect('/admin/users');
    }

    public function delete(Request $request, UserServices $services, $userId)
    {
        $user = $services->deleteUser($userId);
        if($request->wantsJson()){
            return response()->json(['user'=>$user, 'message'=>"User Deleted!"]);
        }
        return redirect('/admin/users/index');
    }
}
