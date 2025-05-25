<?php

namespace App\Http\Controllers;

use App\Models\Masters\Role_authorization; // Correct import for Mail

use App\Models\PasswordReset;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use view;

class HomeController extends Controller
{

    /**
     * Function Name :  getlogin
     * Purpose       :  This function use for show the login page.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads login page
     */

    public function getlogin()
    {
        // echo Hash::make('Welcome1@');
        if (!empty(Session::get('admin'))) {
            return redirect('dashboard');
        } else {
            return view('home/login');
        }
    }

    /**
     * Function Name :  DoLogin
     * Purpose       :  This function use for login the user.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  loads login information on success and load add page for any error during the operation
     */

    public function DoLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'psw' => 'required',

            ],
            [
                'email.required' => 'Email Required',
                'psw.required' => 'Password Required',
            ]
        );

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        } else {
            $user = User::where('email', '=', $request->input('email'))
                ->where('user_type', '=', 'user')
                ->first();

            $useradmin = User::where('email', '=', $request->input('email'))
                ->where('user_type', '=', 'admin')
                ->first();
            if (!empty($user)) {
                if (Hash::check($request->input('psw'), $user->password)) {

                    Session::put('adminusernmae', $request->email);
                    Session::put('adminpassword', $request->psw);
                    Session::put('admin', $user);
                    return redirect()->intended('dashboard');
                } else {
                    Session::flash('error', 'Your email and password wrong!!');
                    return redirect('/');
                }
            } else if (!empty($useradmin)) {
                if (Hash::check($request->input('psw'), $useradmin->password)) {
                    Session::put('adminusernmae', $request->email);
                    Session::put('adminpassword', $request->psw);
                    Session::put('admin', $useradmin);
                    return redirect()->intended('dashboard');
                } else {
                    Session::flash('error', 'Your email and password wrong!!');
                    return redirect('/');
                }
            } else {
                Session::flash('error', 'Your email and password wrong!!');
                return redirect('/');
            }
        }
    }

    /**
     * Function Name :  Dashboard
     * Purpose       :  This function use for show the dashboard .
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads dashboard page
     */
    public function Dashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('home/dashboard', $data);
        } else {
            return redirect('/');
        }
    }
    /**
     * Function Name :  Logout
     * Purpose       :  This function use logout from admin.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  logout from admin.
     */

    public function Logout(Request $request)
    {
        Session::forget('admin');
        Session::forget('role');
        Session::forget('token');
        Session::flash('message', 'You have successfully logged out.');
        return redirect('/');
    }

    /**
     * Function Name :  add
     * Purpose       :  changepassword function renders the add form
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  N/A
     * Return Value  :  return to add page
     */

    public function changepassword()
    {
        if (!empty(Session::get('admin'))) {
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('home/change-password', $data);
        } else {
            return redirect('/');
        }
    }

    /**
     * Function Name :  savechangepassword
     * Purpose       :  This function use for change the password.
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  Request $request
     * Return Value  :  loads listing page on success and load add page for any error during the operation

     */

    public function savechangepassword(Request $request)
    {
        if (!empty(Session::get('admin'))) {

            $user_name = Session::get('adminusernmae');
            $current_password = Session::get('adminpassword');

            if ($request['old_pass'] != $current_password) {
                // The passwords matches
                Session::flash('error', 'Your current password does not matches with the password you provided. Please try again.');
                return redirect()->back();
            } else if ($request['new_pass'] != $request['confirm_pass']) {
                Session::flash('error', 'New Password doesnot match with confirm password.');
                return redirect()->back();
            } else {

                $password = Hash::make($request['new_pass']);
                User::where('email', '=', $user_name)->update(['password' => $password]);
                Session::flash('message', 'Password changed successfully !');
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * Function Name :  Masters Dashboard
     * Purpose       :  This function use for show the dashboard .
     * Author        :
     * Created Date  :
     * Modified date :
     * Input Params  :  NIL
     * Return Value  :  loads dashboard page
     */
    public function mastersdashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('masters/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function projectsdashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('projects/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function timesheetsdashboard()
    {

        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();

            return view('timesheets/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function hcmdashboard()
    {
        if (!empty(Session::get('admin'))) {

            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')

                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', Session::get('adminusernmae'))
                ->get();
            return View('dashboard/hcm-dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function FinanceDashboard()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return View('finance/finance-dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function ProjectDashboard()
    {
        if (!empty(Session::get('admin'))) {
            $email = Session::get('adminusernmae');
            $data['Roledata'] = Role_authorization::leftJoin('modules', 'role_authorizations.module_name', '=', 'modules.id')
                ->leftJoin('sub_modules', 'role_authorizations.sub_module_name', '=', 'sub_modules.id')
                ->leftJoin('module_configs', 'role_authorizations.menu', '=', 'module_configs.id')
                ->select('role_authorizations.*', 'modules.module_name', 'sub_modules.sub_module_name', 'module_configs.menu_name')
                ->where('member_id', '=', $email)
                ->get();

            return View('projectstimesheets/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    // Show email input form
    public function showLinkRequestForm()
    {
        return view('home/password/email');
    }

    // Send OTP to the user's email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }

        // $otp = "123456";
        $token = uniqid(mt_rand(), true);

        //save token for forgot password request
        $resetPwd = new PasswordReset();
        $resetPwd->email = $user->email;
        $resetPwd->token = $token;
        $resetPwd->save();

        $url = Route('admin_reset_newpassword', \Helpers::encryptId($user->email . '_' . $token));

        $message = `<p>You have requested to reset your login password. Please click on the button below to reset it. </p>`;
        $message = $message . '<p>Email : ' . $user->email . '</p>';
        $message = $message . '<p><a style="text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="' . $url . '" target="_blank">Reset Now</a></p>';

        $subject = "Reset Password";

        $data = array(
            'to_salutation' => 'Hello',
            'body_content' => $message,
        );

        $toemail = $user->email;
        Mail::send('mailcommon', $data, function ($message) use ($toemail, $subject) {
            $message->to($toemail, 'Qolaris Data')->subject
                ($subject);
            $message->from('info@qolarisdata.com', 'Qolaris Data');
        });
        // session(['otp' => $otp, 'reset_email' => $request->email]);
        Session::flash('message', 'A reset password link has been sent to your registered email id.');
        return redirect('password/email');
        // return redirect()->route('password/email')->with('status', 'A link has been sent to your email id.');
    }

    public function resetPassword($encryptToken)
    {
        try {
            $decryptToken = \Helpers::decryptId($encryptToken); //decrypt the token
            $tokenArr = explode("_", $decryptToken);
            $email = $tokenArr[0];
            $token = $tokenArr[1];

            $data['email'] = $email;
            $data['token'] = $encryptToken;
            //check whether this token exist or not
            $resultToken = PasswordReset::where([
                ['email', $email],
                ['token', $token],
            ])->get();

            if (!$resultToken->count() > 0) {
                return \Redirect::Route('admin_forgot_password')->with('error', 'The link has expired.');
            }
            // dd($data);
            return view('home/password/reset-password', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function updatePassword(Request $request)
    {
        // dd($request->token);
        try {

            $Validator = Validator::make($request->all(), [
                'password' => 'required|min:5',
                'confirm_password' => 'required|same:password',
            ]
            );

            if ($Validator->fails()) {
                // dd($Validator);
                return \Redirect::back()->withErrors($Validator);
            } else {
                $decryptToken = \Helpers::decryptId($request->token); //decrypt the token
                $tokenArr = explode("_", $decryptToken);
                $email = $tokenArr[0];
                $token = $tokenArr[1];

                $password = $request->password;
                $confPassword = $request->confirm_password;
                $objUser = User::where('email', $email)->first();

                if (!empty($objUser)) { //if user exist

                    if (!(Hash::check($request->input('password'), $objUser->password))) {
                        $objUser->password =  Hash::make($password);;
                        $objUser->save();
                        $objReset = PasswordReset::where('token', $token)->delete();
                        Session::flash('message', 'Password reset successfully.');
                        return redirect('/');
                    } else {
                        return \Redirect::back()->with('error', 'New password should not be same with the old password');
                    }
                } else {
                    //session()->flash('alert-danger', 'Something went Wrong. Please try reset password again.');
                    return \Redirect::back()->with('error', 'Some error occurred. Please try again');
                }
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


}
