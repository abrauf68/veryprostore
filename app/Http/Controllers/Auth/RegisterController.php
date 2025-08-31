<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserBankDetail;
use App\Models\UserShop;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.register');
        }
    }

    public function register_attempt(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => 'required|same:password',
            'transaction_password' => ['required', 'string', 'min:8'],
            'confirm_transaction_password' => 'required|same:transaction_password',
            'shop_name' => ['required', 'string', 'max:255'],
            'certificate_type' => ['required', 'string', 'max:255'],
            'certificate_front' => 'required|image|mimes:jpeg,png,jpg|max_size',
            'certificate_back' => 'required|image|mimes:jpeg,png,jpg|max_size',
            'invitation_code' => 'required|string|max:255',
            'terms' => 'required|string|max:255',
        ];

        // Make 'g-recaptcha-response' nullable if CAPTCHA is not enabled
        if (config('captcha.version') !== 'no_captcha') {
            $rules['g-recaptcha-response'] = 'required|captcha';
        } else {
            $rules['g-recaptcha-response'] = 'nullable';
        }

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            Log::error('Validation Error', ['error' => $validate->errors()]);
            return Redirect::back()->withErrors($validate)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {

            if ($request->invitation_code) {
                $companyInvitationCode = CompanySetting::first()->invitation_code;
                if ($request->invitation_code != $companyInvitationCode) {
                    return redirect()->back()->withInput($request->all())->with('error', 'Invalid Invitation Code');
                }
            }

            // Begin a transaction
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->transaction_password = $request->transaction_password;
            $user->is_active = 'inactive';

            // if ($request->invitation_code) {
            //     $inviter = User::where('username', $request->invitation_code)->first();
            //     if ($inviter) {
            //         $user->invited_by = $inviter->id;
            //     }
            // }

            $username = $this->generateUsername($request->name);

            while (User::where('username', $username)->exists()) {
                $username = $this->generateUsername($request->name);
            }
            $user->username = $username;
            $user->email_verified_at = now();
            $user->save();

            $user->syncRoles('vendor');

            $userShop = new UserShop();
            $userShop->user_id = $user->id;
            $userShop->shop_name = $request->shop_name;
            $userShop->certificate_type = $request->certificate_type;
            if ($request->hasFile('certificate_front')) {
                $certificate_front = $request->file('certificate_front');
                $certificate_front_ext = $certificate_front->getClientOriginalExtension();
                $certificate_front_name = time() . '_certificate_front.' . $certificate_front_ext;

                $certificate_front_path = 'uploads/certificates';
                $certificate_front->move(public_path($certificate_front_path), $certificate_front_name);
                $userShop->certificate_front = $certificate_front_path . "/" . $certificate_front_name;
            }
            if ($request->hasFile('certificate_back')) {
                $certificate_back = $request->file('certificate_back');
                $certificate_back_ext = $certificate_back->getClientOriginalExtension();
                $certificate_back_name = time() . '_certificate_back.' . $certificate_back_ext;

                $certificate_back_path = 'uploads/certificates';
                $certificate_back->move(public_path($certificate_back_path), $certificate_back_name);
                $userShop->certificate_back = $certificate_back_path . "/" . $certificate_back_name;
            }
            $userShop->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->first_name = $request->name;
            $profile->save();

            $userBankDetails = new UserBankDetail();
            $userBankDetails->user_id = $user->id;
            $userBankDetails->save();

            // Attempt to authenticate
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if (Auth::check()) {

                // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
                //     return (new MailMessage)
                //         ->subject('Verify Email Address')
                //         ->line('Click the button below to verify your email address.')
                //         ->action('Verify Email Address', $url);
                // });

                DB::commit();
                return redirect()->route('frontend.account')->with('success', 'Your account has been created successfully.');
            } else {
                DB::rollback();
                return redirect()->back()->withInput($request->all())->with('error', "Something went wrong! Please try again later");
            }
            // app('notificationService')->notifyUsers([$user], 'Welcome to ' . Helper::getCompanyName());
            // $user->sendEmailVerificationNotification();

            // Commit the transaction
        } catch (\Throwable $th) {
            DB::rollback();
            // Log the error for debugging
            Log::error('User registration failed', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all())->with('error', "Something went wrong! Please try again later");
            // throw $th;
        }
    }

    public function generateUsername($name)
    {
        $name = strtolower(str_replace(' ', '', $name));
        $username = $name . rand(1000, 9999);
        return $username;
    }

    // protected function generateUsername($name)
    // {
    //     $firstThreeLetters = strtoupper(substr($name, 0, 3));
    //     $randomNumber = rand(1000, 999999);
    //     return $firstThreeLetters . $randomNumber;
    // }
}
