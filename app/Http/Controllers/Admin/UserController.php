<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Nevar dzēst pats sevi!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Lietotājs veiksmīgi dzēsts!');
    }
}
