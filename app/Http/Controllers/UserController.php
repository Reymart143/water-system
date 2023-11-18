<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use dataTables;
use App\Models\ReportLog;

class UserController extends Controller
{
    
    public function create(Request $request){
       
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'phoneNumber' => 'required|digits:11',
            'address' => 'required',
            'role' => 'required',
            'name.required' => 'Please enter a name.',
            'username.required' => 'Please enter an employee ID.',
            'username.unique' => 'This username is already taken.',
            'image.required' => 'Please select an image.',
            'password.required' => 'Please enter a password.',
            'phoneNumber.required' => 'Please enter a phone number.',
            'phoneNumber.digits' => 'The phone number must be exactly 11 digits.',
            'address.required' => 'Please enter an address.',
            'role.required' => 'Please select a role.',
        ]);
            if($request->image == null){
                $img = $request->image;
                $folderPath = "public/";
                
                $image_parts = explode(";base64,", $img);
            
                $image_type_aux = explode("image/", $image_parts[0]);
                
                $image_type = $image_type_aux[0];

                $image_base64 = base64_decode($image_parts[0]);
                $fileName = uniqid() . '.png'.'.jpg'.'.GIF'.'.BMP';
                $fileName = str_replace(' ', '_', $fileName);
            
                $file = $folderPath . $fileName;
                Storage::put($file, $image_base64);
                $hashed = Hash::make($request->password);
            }
                else{
                    $img = $request->image;
                    $folderPath = "public/";
                    
                    $image_parts = explode(";base64,", $img);
                
                    $image_type_aux = explode("image/", $image_parts[0]);
                    
                    $image_type = $image_type_aux[1];
            
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png'.'.jpg'.'.GIF'.'.BMP';
                    $fileName = str_replace(' ', '_', $fileName);
                
                    $file = $folderPath . $fileName;
                    Storage::put($file, $image_base64);
                }
        
        $hashed = Hash::make($request->password);
        $Usersform = DB::table('users')->insert([
            'name'=> $request->name,
            'username' => $request->username,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address,
            'role' => $request->role,
            'image'=>$fileName,
            'password'=> $hashed,
        ]);
    
        if ($Usersform != null){
            return response()->json([
                    
                'status'=>200,
                'message'=> 'Successfully Registered as User in this System',
                
            ]);
        }else{
            return response()->json([
                    
                'status'=>400,
                'message'=> 'An error Occured' ,
                
            ]);
        }
        
    }
    public function admin(Request $request){
        
        $hashed = Hash::make($request->password);
        
        $initialform = DB::table('users')->insert([
        
            'name'=> $request->name,
            'username' => $request->username,
            'password'=> $hashed,
        ]);
        if ($initialform != null){
            return response()->json([
                    
                'status'=>200,
                'message'=> 'Successfully Registered as User in this System',
                
            ]);
        }else{
            return response()->json([
                    
                'status'=>400,
                'message'=> 'An error Occured' ,
                
            ]);
        }
    }
    // public function loginuser(Request $request)
    //     {
    //         $credentials = $request->only('username', 'password');
            
    //         if (Auth::attempt($credentials)) {
    //             $user = Auth::user();
    //             $allowedRoles = [1, 2, 3, 4];
    //             if (in_array($user->role, $allowedRoles)) {
    //                 ReportLog::create([
    //                     'user_id' => $user->id,
    //                     'date' => now()->toDateString(),
    //                     'time' => now(),
    //                 ]);
    //             }
    //             \Session::flash('success', 'Welcome ' . $user->name . '! You have successfully logged in.');
                    
    //             if(Auth::user()->role == 0 || Auth::user()->role == 1)
    //                 {
    //                     return redirect()->route('home');
    //                 }
    //                 elseif(Auth::user()->role == 2)
    //                 {
    //                     return redirect()->route('collection.treasurer-receipt');
    //                 }
    //                 elseif(Auth::user()->role == 3)
    //                 {
    //                     return redirect()->route('billing.encoder-billing');
    //                 }
    //                 elseif(Auth::user()->role == 4)
    //                 {
    //                     return redirect()->route('master-list');
    //                 }
    //         } else {
        
    //             \Log::error('Invalid login attempt for username: ' . $request->input('username'));
                
    //             return redirect("login")
    //                 ->withErrors('Oops! You have entered invalid credentials')
    //                 ->with('swal', 'invalid_credentials');
    //         }
            
    //     }
    public function loginuser(Request $request)
{
    $credentials = $request->only('username', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $allowedRoles = [1, 2, 3, 4];
        
        if (in_array($user->role, $allowedRoles)) {
            ReportLog::create([
                'user_id' => $user->id,
                'date' => now()->toDateString(),
                'time' => now(),
            ]);
        }
        
        if ($user->status == 1) {
            \Auth::logout(); 
            return redirect("login")
                ->withErrors('warning', 'Please contact the admin to enable your account.')
                ->with('swal', 'warning');
        }
        
        \Session::flash('success', 'Welcome ' . $user->name . '! You have successfully logged in.');
        
        if (Auth::user()->role == 0 || Auth::user()->role == 1) {
            return redirect()->route('home');
        } elseif (Auth::user()->role == 2) {
            return redirect()->route('collection.treasurer-receipt');
        } elseif (Auth::user()->role == 3) {
            return redirect()->route('billing.encoder-billing');
        } elseif (Auth::user()->role == 4) {
            return redirect()->route('master-list');
        }
    } else {
        \Log::error('Invalid login attempt for username: ' . $request->input('username'));
        
        return redirect("login")
            ->withErrors('Error! You have entered invalid credentials')
            ->with('swal', 'invalid_credentials');
    }
}
        public function verifyPassword(Request $request)
        {
            $user = Auth::user();

            if (Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Password verified']);
            } else {
                return response()->json(['error' => 'Incorrect password'], 401);
            }
        }

    public function index(Request $request){
        if ($request->ajax()) {
            $userRole = Auth::user()->role;
            $superAdminData = DB::table('users')
                         ->where('role', '<>', 0)
                         ->when($userRole == 1, function ($query) {
                            return $query->where('role', '<>', 1);
                        })
                        ->orderBy('users.name','asc')
                        ->select('id', 'name', 'image', 'username','address','phoneNumber','role','status')
                        ->get();
    
                        return datatables()->of($superAdminData)->addIndexColumn()
            
                        ->addColumn('action', function($superAdminData){
                            $button = '
                                <input type="hidden" id="emp_'.$superAdminData->id.'" value="'.$superAdminData->username.'" data-name="'.$superAdminData->name.'" />
                                <button type="button" name="edit" onclick="editSuperAdmin('.$superAdminData->id.')" class="action-button accept btn btn-success btn-sm" style="margin-left:20px;padding-top: 2mm;padding-bottom: 2mm;padding-left: 3mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-edit"></i>  <span class="action-text" style="font-size:12px">Edit</span></button>
                                <button type="button" name="softDelete" onclick="confirmDelete(' . $superAdminData->id . ')" class="action-button softDelete btn btn-danger btn-sm" style="margin-left:7px;padding-top: 2mm;padding-bottom: 2mm; padding-left: 4mm; padding-right: 3mm;font-size: 10px;"><i class="fa fa-trash-o"></i>  <span class="action-text" style="font-size:8px">Delete</span></button>
                                ';
                        return $button;
                        })
                        ->make(true);
                    }
        return view('userManagement.user');
    }
    public function updateStatus(Request $request){
      
            $id = $request->input('id');
            $status = $request->input('select_status');
        
            try {
              
                $UserStatus = User::findOrFail($id);
        
             
                $UserStatus->status = $status;
        
            
                $UserStatus->save();
        
            
                return response()->json(['message' => 'Status updated successfully'], 200);
            } catch (\Exception $e) {
                
                return response()->json(['message' => 'Failed to update status'], 500);
            }
        
    }
    public function edit($id)
        {
           
            if(request()->ajax())
            {
                $data = User::findOrFail($id);
                return response()->json(['result' => $data]);
            }
        }
        
        public function update(Request $request)
        {
    
            $Usersform = DB::table('users')->where('id', $request->id)->update([
                'name'=>$request->name,
                'username'=>$request->username,
                'phoneNumber'=>$request->phoneNumber,
                'role'=>$request->role,
            ]);
           
            return response()->json([
                'status'=> 200,
                'message'=>'Success Update Info!!'
            ]);
    
        }
        public function delete($id)
        {
            return view('confirm-delete', ['id' => $id]);
        }
    
        public function softDelete($id){
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json(['message' => 'User deleted successfully']);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'User not found'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while deleting the user'], 500);
            }
        }
      
}
