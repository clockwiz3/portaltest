<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationCode;
use App\Models\News;

class ControlPanelController extends Controller
{
    public function index()
    {
        $verifiedUsers = User::whereNotNull('verified_at')->pluck('name');
        $nonVerifiedUsers = User::whereNull('verified_at')->pluck('name');
        $verificationCodes = VerificationCode::with('user')->get();
        $news = News::paginate(10);

        return view('controlpanel.index', compact('verifiedUsers', 'nonVerifiedUsers', 'verificationCodes', 'news'));
    }
}
