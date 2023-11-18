<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(){
        return view ('profile.superadmin');
    }
    public function SuperAdminProfile_update(Request $request)
    {
        $user = Auth::user();
        $name = $request->input('name');
        $username = $request->input('username');
        $address = $request->input('address');
        $phoneNumber = $request->input('phoneNumber');
    
        $profile_update_data = [
            'name' => $name,
            'username' => $username,
            'address' => $address,
            'phoneNumber' => $phoneNumber,
        ];
    
        $newPassword = $request->input('new_password');
        if (!empty($newPassword)) {
       
            if (!Hash::check($request->input('password'), $user->password)) {
                return response()->json(['message' => 'Old password is incorrect'], 400);
            }
            
         
            $profile_update_data['password'] = Hash::make($newPassword);
        }
    
  
        $profile_update = DB::table('users')
            ->where('id', $user->id)
            ->update($profile_update_data);
    
        if ($profile_update > 0) {
            return response()->json(['message' => 'Profile updated successfully']);
        } else {
            return response()->json(['message' => 'User not found']);
        }
    }
    public function superadmin_upload_update(Request $request)
    {
        $user = Auth::user()->id;
        $img = $request->image;
        $folderPath = "public/";

        $image_parts = explode(";base64,", $img);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png' . '.jpg' . '.GIF' . '.BMP';
        $fileName = str_replace(' ', '_', $fileName);

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        $profile_photo_update = DB::table('users')
            ->where('id', $user)
            ->update(['image' => $fileName]);

        if ($profile_photo_update > 0) {
            return response()->json(['message' => 'Profile picture updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update Profile Picture']);
        }
    }
}
