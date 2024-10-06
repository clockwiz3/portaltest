<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\VerificationCode;
use App\Models\User;
class VerificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('auth.verify', ['user' => $request->user]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|integer',
        ]);

        $verification = VerificationCode::where('user_id', $request->user)
            ->where('code', $request->code)
            ->first();

        if ($verification) {
            $user = User::find($request->user);
            $user->verified_at = now();
            $user->save();

            Auth::login($user);


            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['code' => 'Неверный код']);
        }
    }
}
