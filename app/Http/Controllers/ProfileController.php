<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['required', 'current_password'],
        ]);

        $data = ['name' => $validated['name'], 'phone' => $validated['phone']];

        if ($request->filled('new_password')) {
            $request->validate(['new_password' => ['string', 'min:8', 'confirmed']]);
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        return back()->with('success', "Profil yangilandi.");
    }
}
