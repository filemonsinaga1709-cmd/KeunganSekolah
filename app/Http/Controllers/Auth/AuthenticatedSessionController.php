<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

 public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();
    
    // DEBUG
    \Log::info('User Role: ' . $user->role);
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'bendahara') {
        return redirect()->route('bendahara.dashboard');
    } elseif ($user->role === 'tu') {
        return redirect()->route('tu.dashboard');
    } elseif ($user->role === 'kepala_sekolah') {
        return redirect()->route('kepala-sekolah.dashboard');
    }
    
    return redirect('/');
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}