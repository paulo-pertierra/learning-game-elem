<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Users', [
            'users' => User::paginate(30)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required']
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'grade_level' => $request->grade_level
        ]);

        event(new Registered($user));

        return;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => ['required']
        ]);

        $user = User::find($id);

        $user->role = $request->role;
        if ($request->grade_level) $user->grade_level = $request->grade_level;

        $user->save();

        return;
    }

    public function destroy($id) {
        $user = User::find($id);
        $user->delete();
        return;
    }
}
