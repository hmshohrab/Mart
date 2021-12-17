<?php

namespace App\Http\Controllers\Auth;

//use App\Helpers\App\Traits\ReCaptchaHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use App\Helpers;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use App\Models\Auth as ModelsAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // use ReCaptchaHelper;
    public function show()
    {
        return auth()->user()->load('roles:id,name', 'profile:id,user_id,gender,date_of_birth,address,contact', 'profilePicture', 'status:id,name,class', 'socialLinks');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerView()
    {
        $recaptcha = $this->getReCaptcha();
        return view('frontend.user.invitation_confirm', $recaptcha);
    }
    public function loginView()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where(['email' => $request['email']])->first();
        //$this->sendEmailReminder($request, $user->id);
        if (isset($user) && $user->is_active && auth('users')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('admin/dashboard');
        }/*  else {
            return redirect('login')->with('error', $this->error_processor($validator));
            //  return response()->json(['success' => false, 'message' => 'login failed', 'data' => $user]);
        } */
        return redirect('admin/login')->with('error', 'Credentials do not match or account has been suspended!');
        // return response()->json(['message' => 'Credentials do not match or account has been suspended.'], 401);
        return back();
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

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $user = User::where(['email' => $request['email']])->first();
        if (isset($user) && $user->is_active && auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
            if ($request->ajax()) {
                return response()->json(['message' => 'Signed in successfully!', 'url' => session('keep_return_url')]);
            }
            Toastr::info('Welcome to ' . $this->company_name->value . '!');
            return redirect(session('keep_return_url'));
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Credentials do not match or account has been suspended.'], 401);
        }

        Toastr::error('Credentials do not match or account has been suspended.');
        return back();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            // return redirect()->route('login', ['errors' => $this->error_processor($validator)]);
            return redirect('admin/login')->with('error', $this->error_processor($validator));
            // return response()->json(['errors' => $this->error_processor($validator)]);
        }

        if ($request['password'] != $request['repeatpass']) {
            return redirect('admin/login')->with('error', 'password does not match.');
        }
        /*  DB::table('users')->insert([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'is_active' => true
        ]); */
        $otp = rand(1000, 9999);
        $data = array(
            'name' => "Md. shohrab hossen ", 'message' => $request->message, 'email' => $request->email, 'subject' => "OTP for ebay",
            'otp' => $otp
        );
        Mail::to($request->email)->send(new OtpMail($data));

        $id =  ModelsAuth::create([
            'first_name' => $request->first_name, 'last_name' => $request->last_name,
            'email' => $request->email, 'otp' => $otp, 'otp_type' => 1, 'is_used' => 0
        ]);
        $request['auth_id'] = $id->id;
        Session::put('user', $request->all());
        //  dd($id);


        return redirect()->route('admin.verifyView');

        /*   if (auth('users')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('admin/dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Something went wrong.']);
 */
        /* 
          return response()->json(['data' => $validator]);
        if (!isset($user)) {
            $id = User::create($request->all());
            return response()->json(['success' => true, 'message' => "", 'data' => $id]);
        } else {
            return response()->json(['success' => false, 'message' => "", 'data' => '$id']);
        } */
    }
    public function verifyView()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.verify');
    }

    public function verify(Request $request)
    {  
        $user = (session()->has('user'))  ? session('user'): [];
       
        $validator = Validator::make($user, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        
         if ($validator->fails()) { 
            return response()->json(['success' => false, 'message' =>'Validation failed', 'data' => $this->error_processor($validator)]);
        } 
        $auth =  ModelsAuth::where('email', $user['email'])->where('id', $user['auth_id'])->where('is_used', 0)->where('otp', $request['otp'])->get();
         if (!$auth->isEmpty()) {
            $id = ModelsAuth::where('email', $user['email'])->where('id', $user['auth_id'])->where('is_used', 0)->where('otp', $request['otp'])->update(['is_used' => 1]);
            Log::info('Auth Data', ['info' => $id]);
            $insertedData = User::create([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'username' => Str::slug($user['first_name'],'-') .'-'. Str::random(6),
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
                'is_active' => true
            ]);
            if (isset($user) && $insertedData->is_active && auth('users')->attempt(['email' => $user['email'], 'password' => $user['password']])) {
                return response()->json(['success' => true, 'message' => 'Successfully fetched!', 'data' => ['user' => $user, 'auth' => $auth[0],'user1'=>$insertedData]], 200);
            }else{
                return response()->json(['success' => false, 'message' => 'Information not valid!'], 451);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Auth not found'], 401);
        }
    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

    public function register1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request['password'] != $request['con_password']) {
            return response()->json(['errors' => ['code' => '', 'message' => 'password does not match.']], 403);
        }

        if (session()->has('keep_return_url') == false) {
            session()->put('keep_return_url', url()->previous());
        }

        DB::table('users')->insert([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password'])
        ]);

        if (auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return response()->json(['message' => 'Sign up process done successfully!', 'url' => session('keep_return_url')]);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Something went wrong.']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPasswordView()
    {
        $recaptcha = $this->getReCaptcha();
        return view('frontend.user.reset_password', $recaptcha);
    }

    public function logout()
    {
        Log::debug("Logout");
        if (Auth::guard('users')->check()) {
            auth()->guard('users')->logout();
        }
        return redirect('admin/login');
    }
}
