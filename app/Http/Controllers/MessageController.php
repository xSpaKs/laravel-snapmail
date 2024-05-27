<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;
use Str;

class MessageController extends Controller
{
    public function showForm() 
    {
        return view("form");
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $token = Str::random(20);
        $email = $request->input("email");
        $message = $request->input("message");

        DB::table('messages')->insert([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'message' => $message,
            'photo' => Str::random(10),
            'token' => $token,
        ]);

        Mail::raw($message, function ($message_) use ($email) {
            $message_->to($email)
                    ->subject('Nouveau message');
        });

        redirect("/");
    }   

    public function showMessage()
    {
        $token = substr(url()->current(), strrpos(url()->current(), '/') + 1);
        $message = DB::table("messages")->where('token', $token)->get()->first()->message;
        DB::table("messages")->where('token', $token)->delete();
        
        return view("message")->with('message', $message);
    }
}
