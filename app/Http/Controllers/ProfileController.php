<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.show')->with('user', $user_a);
    }

    public function edit(){
       // $user_a = $this->user->findOrFail(Auth::user()->id);
       return view('user.profiles.edit');
    }

    public function update(Request $request){
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id,
            // CREATING: unique:<table>,<column>
            // UPDATING: unique:<table>,<column>,<id>
            'introduction' => 'max:100'
        ]);

        $user_a = $this->user->findOrFail(Auth::user()->id);

        if($request->avatar){
            $user_a->avatar = 'data:image/'.$request->avatar->extension().
                                ';base64,'.base64_encode(file_get_contents($request->avatar));
        }
        $user_a->name = $request->name;
        $user_a->email = $request->email;
        $user_a->introduction = $request->introduction;

        $user_a->save();

        //go to profile page
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function following($id){
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.following')->with('user', $user_a);
    }

    public function followers($id){
        $user_a = $this->user->findOrFail($id);

        return view('user.profiles.followers')->with('user', $user_a);
    }

    public function updatePassword(Request $request){

        $user_a = $this->user->findOrFail(Auth::user()->id);

        //check if old password is correct
        if(!Hash::check($request->old_password, $user_a->password)){
            //go back to form, display error
            return redirect()->back()->with('old_password_error', 'Your current password is incorrect.');
        }

        //new password cannot be the same as old password
        if($request->old_password == $request->new_password){
            //go back to form, display error
            return redirect()->back()->with('same_password_error', 'New password cannot be the same as current password');
        }

        //confirm new password (must match)
        $request->validate([
            'new_password' => 'required|min:8|string|confirmed'
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()->with('confirm_success_password', 'Changed password succesfully!');
    }
}
