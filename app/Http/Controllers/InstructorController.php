<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function InstructorDashboard()
    {
        return view('instructor.instructor_dashboard');
    }

    public function InstructorLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/instructor/login');
    }

    public function InstructorLogin(Request $request)
    {
        return view('instructor.instructor_login');
    }

    public function InstructorProfile(Request $request)
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_profile', compact('profileData'));
    }

    public function InstructorProfileUpdate(Request $request)
    {
        $data = array(
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
        );
        $user_id = Auth::user()->id;
        $row = array();
        $check_user = User::check_users($data, $user_id);
        if (!empty($check_user)) {
            $row['res'] = '2';
        } else if (!empty($user_id)) {
            if ($request->hasFile('photo')) {
                // Delete the existing photo if it exists
                $existingPhoto = Auth::user()->photo;
                if ($existingPhoto && Storage::disk('public')->exists('files/user/' . $existingPhoto)) {
                    Storage::disk('public')->delete('files/user/' . $existingPhoto);
                }
    
                // Upload the new photo to storage folder
                $filename = 'photo_' . time() . '.' . $request->photo->extension();
                $request->photo->storeAs('files/user', $filename, 'public');
                $data['photo'] = $filename;
            }
            $data['status'] = '1';
            $data['updated_at'] = now();
            $updateid = User::where('id', $user_id)->update($data);
            if ($updateid) {
                unset($data["updated_at"]);
                $data['user_id'] = $user_id;
                $data['created_at'] = now();
                $row['res'] = '3';
            } else {
                $row['res'] = '0';
            }
        }
    
        return $row;
    }
    

    public function InstructorChangePassword(Request $request)
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_change_password',compact('profileData'));
    }

    public function InstructorPasswordUpdate(Request $request)
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
