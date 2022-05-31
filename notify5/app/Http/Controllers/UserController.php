<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function register()
    {
        return view('pages.register');
    }

    public function store_register(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        
        if($user) {
            return response()->json(['exists' => 'Email Already Exists']);
        } else {
            $user = new User;
            $user->name = $request['name'];
            $user->operator = $request['operator'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        return response()->json(['success' => 'User Registered Successfully']);
    }

    public function login(){
        return view('pages.login');
    }

    public function user_login(Request $request){
        
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')])) {
            $user = Auth()->user();
                return response()->json(['success' => 'Successfully Logged In']);
 
        } else {
            return response()->json(['error'=> 'Something went wrong']);
        }
    }

    public function dashboard()
    {
        $notifications = DB::select("SELECT users.id, users.name, users.email, users.operator, COUNT(is_read) AS unread FROM users LEFT JOIN reports ON users.id = reports.user_id AND reports.is_read = 0 WHERE users.id = ".Auth::id()." GROUP BY users.id, users.name, users.email, users.operator");
        
        return view('dashboard', compact('notifications', 'notifications'));
    }
}
