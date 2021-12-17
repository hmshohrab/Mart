<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function otpEmail(Request $request)
    {
        $otp = rand(1000, 9999);
        $data = array('name' => "Md. shohrab hossen ", 'message' => $request->message, 'email' => $request->to, 'subject' => $request->subject,
    'otp'=>$otp);

        Mail::to($request->to)->send(new OtpMail($data));
        return back()->with('success', 'Email Sent. Check your inbox.');
    }
    public function createCompose()
    {
        $user = Auth::guard('users')->user();
        if (!Auth::guard('users')->check()) {
            return redirect()->route('admin.login');
        }
        return view('emails.compose', ['user' => $user]);
    }

    public function send(Request $req)
    {

        dd($req->all());

        Mail::send('emails.loginSuccess', [
            'data' => $req->message
        ], function ($message) use ($req) {
            $message->to($req->to, $req->subject);
            $message->subject($req->subject);
        });
        return back()->with('success', 'Mail send done');
    }

    public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('auth.login', ['user' => $user], function ($m) use ($user) {
            $m->from('hmshohrabpc@gmail.com', 'Your Application');

            $m->to(
                $user->email,
                $user->first_name
            )->subject('Your Reminder!');
        });
    }

    public function basic_email(Request $request)
    {
        $otp = rand(1000, 9999);
        $data = array('name' => "Md. shohrab hossen ", 'message' => $request->message, 'email' => $request->to, 'subject' => $request->subject,
    'otp'=>$otp);

        Mail::to($request->to)->send(new OtpMail($data));
        /*  Mail::send(['text' => 'emails.otp'], $data, function ($message) use ($request) {
            $message->to($request->to, 'Tutorials Point')->subject($request->subject);
            $message->from('hmshohrabpc@gmail.com', 'Md. shohrab hossen');
        }); */
        return back()->with('success', 'Email Sent. Check your inbox.');
    }

    public function html_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel HTML Testing Mail');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
    public function attachment_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send('mail', $data, function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
