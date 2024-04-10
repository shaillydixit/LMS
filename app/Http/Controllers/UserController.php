<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index()
    {
        return view('frontend.index');
    }

    public function UserLogout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function UserChangePassword(){
        return view('frontend.user_dashboard.change_password');
    }

    public function UserPasswordUpdate(Request $request)
	{
		if (!Hash::check($request->old_password, auth()->user()->password)) {
			$row['res'] = '2';
		} else {
			$update = User::whereId(auth()->user()->id)->update([
				'password' => Hash::make($request->new_password)
			]);
			if ($update) {
				$row['res'] = '1';
			} else {
				$row['res'] = '0';
			}
		}
		return $row;
	}
}
