<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\AuditLog;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $original = $user->only(['name', 'email']); // Capture original values

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $changes = [];

        if ($user->name !== $validated['name']) {
            $changes['name'] = ['old' => $user->name, 'new' => $validated['name']];
        }

        if ($user->email !== $validated['email']) {
            $changes['email'] = ['old' => $user->email, 'new' => $validated['email']];
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $changes['password'] = ['old' => '********', 'new' => '********'];
        }

        $user->save();

        // Audit Log
        if (!empty($changes)) {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'profile_updated',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'old_values' => collect($original)->only(array_keys($changes)),
                'new_values' => collect($user->only(array_keys($changes))),
            ]);
        }

        return redirect()->route('profile.edit')->with('success', 'Profils veiksmīgi atjaunināts!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Audit log before deleting
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'profile_deleted',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'old_values' => $user->only(['name', 'email']),
            'new_values' => null,
        ]);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Jūsu profils tika veiksmīgi dzēsts.');
    }
}
