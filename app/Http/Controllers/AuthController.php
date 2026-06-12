<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|numeric|digits_between:9,15',
            'password' => ['required', 'string'],
        ]);

        $phone = $this->normalizePhone($validated['phone']);

        if (!Auth::attempt(['phone' => $phone, 'password' => $validated['password']])) {
            return back()->withErrors(['phone' => "Telefon raqam yoki parol noto'g'ri."])->onlyInput('phone');
        }

        $request->session()->regenerate();

        return redirect('/students')->with('status', 'Siz tizimga kirdingiz!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect('/login')->with('status', 'Siz tizimdan chiqdingiz.');
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[^\d+]/', '', $phone);
    }
}
