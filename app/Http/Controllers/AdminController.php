<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminLogin(Request $request)
    {
        return view('admin.admin_login');
    }

    public function AdminProfile(Request $request)
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function AdminProfileUpdate(Request $request)
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
    

}
