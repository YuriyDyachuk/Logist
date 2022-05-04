<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Validators\PasswordValid;
use App\Validators\PasswordCheck;

use Illuminate\Support\Facades\Hash;
use App\Models\User;



class ChangePasswordController extends Controller
{
    public function index(Request $request){

        $request->validate([
            'password_old' => ['required', new PasswordCheck()],
//            'password_confirmation' => 'required',
            'password' => ['required', new PasswordValid(), 'confirmed'],
        ]);

        $id = auth()->user()->id;

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['result' => true]);
    }
}
