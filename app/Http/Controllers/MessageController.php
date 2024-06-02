<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('image')) {
            $request->validate([
                'email' => 'required|email',
                'message' => 'required',
                'image' => 'required|image'
            ]);
        } else {
            $request->validate([
                'email' => 'required|email',
                'message' => 'required',
            ]);
        }

        $token = Str::random(20);
        $email = $request->input("email");
        $message = $request->input("message");
        
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = Str::random(20).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName); 
        }

        DB::table('messages')->insert([
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'message' => $message,
            'photo' => $imageName,
            'token' => $token,
        ]);

        Mail::raw("Vous avez un message à consulter, cliquez sur ce lien : http://127.0.0.1:3400/message/{$token}", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Nouveau message');
        });

        return redirect('/')->with('success', 'Le message a été envoyé avec succès.');
    }   

    public function showMessage()
    {
        $token = substr(url()->current(), strrpos(url()->current(), '/') + 1);
        
        $message = DB::table('messages')->where('token', $token)->first();
        
        if (!$message) { 
            return view('message')->with('message', "404 : Ce message n'existe plus")->with('image', null); 
        }
        
        DB::table('messages')->where('token', $token)->delete();
        $image_path = public_path("images/" . $message->photo);
        
        /*if (file_exists($image_path)) { unlink($image_path); }*/
        
        return view('message')->with('message', $message->message)->with('image', $message->photo);
    }
}
