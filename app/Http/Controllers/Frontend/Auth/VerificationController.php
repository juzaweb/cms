<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\User;

class VerificationController extends Controller
{
    public function index($token) {
        try {
            $decrypted = Crypt::decryptString($token);
            $decrypted = json_decode($decrypted);
            $user = User::where('email', '=', $decrypted->email)
                ->where('status', '=', 2)
                ->firstOrFail();
    
            $user->update([
                'status' => 1
            ]);
            
            return view();
        }
        catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return abort(404);
        }
    }
}
