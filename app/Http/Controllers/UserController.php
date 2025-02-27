<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\SubSystem;
use Illuminate\Http\Request;
use App\Models\UserSubSystem;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $subsystems = SubSystem::all();
        return view('users.index', compact('users', 'subsystems'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $subsystems = SubSystem::all();
        return view('users.edit', compact('user', 'subsystems'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'sub_systems' => 'required|array',
            'sub_systems.*' => 'required|exists:sub_systems,id'
        ]);

        $user->update($request->only('name', 'email'));

        $user->usersubsystems()->delete();

        foreach ($request->sub_systems as $key => $subsystem) {
            $userSubSystem = new UserSubSystem();
            $userSubSystem->uuid = Uuid::uuid4();
            $userSubSystem->user_id = $user->id;
            $userSubSystem->sub_system_id = $subsystem;
            $userSubSystem->save();
        }

        return redirect()->route('users.index');
    }
}
