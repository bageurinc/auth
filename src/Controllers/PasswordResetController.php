<?php
namespace Bageur\Auth\Controllers;
// namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Bageur\Auth\Model\password_reset;
use Bageur\Auth\Model\user;
use Bageur\Auth\Notifications\PasswordResetRequest;
use Bageur\Auth\Notifications\PasswordResetSuccess;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|string|email',
        // ]);

        // $user = user::where('email', $request->email)->first();
        
        // if (!$user)
        //     return response()->json([
        //         'message' => 'We can t find a user with that e-mail address.'
        //     ], 404);
        // $passwordReset = password_reset::updateOrCreate(
        //     ['email' => $user->email],
        //     [
        //         'email' => $user->email,
        //         'token' => Str::random(60),
        //      ]
        // );
        // if ($user && $passwordReset)
        //     $user->notify(
        //         new PasswordResetRequest($passwordReset->token)
        //     );
        // return response()->json([
        //     'status' => true,
        //     'text' => 'We have e-mailed your password reset link!'
        // ]);
        $rules    = [
            'email'         => ['required','email', new \Bageur\Auth\Rules\checkUserByemail]
        ];

        $messages = [
        ];

        $attributes = [
        ];
        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $err = [];
            foreach ($rules as $key => $value) {
                if ($errors->has($key)) {
                    $err[$key] = ['text' => $errors->first($key) , 'status' => 'is-danger'];
                }else{
                    $err[$key] = ['text' => '' , 'status' => 'is-success'];
                }
            }
            return response(['status' => false , 'err' => $err],200);
        }else{
               $passwordReset = password_reset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => Str::random(60),
                     ]
                );
                $user         = user::where('email', $request->email)->first();
                $user->notify(
                    new PasswordResetRequest($passwordReset->token)
                );
                return response(['status' => true ,'text'    => 'has input'], 200); 

        }
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = password_reset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        //     'token' => 'required|string'
        // ]);
        // $passwordReset = password_reset::where([
        //     ['token', $request->token],
        //     ['email', $request->email]
        // ])->first();
        // if (!$passwordReset)
        //     return response()->json([
        //         'message' => 'This password reset token is invalid.'
        //     ], 404);
        // $user = user::where('email', $passwordReset->email)->first();
        // if (!$user)
        //     return response()->json([
        //         'message' => 'We can t find a user with that e-mail address.'
        //     ], 404);
        // $user->password = bcrypt($request->password);
        // $user->save();
        // $passwordReset->delete();
        // $user->notify(new PasswordResetSuccess($passwordReset));
        // return response()->json([
        //     'status' => true,
        //     'text' => 'Password telah dirubah'
        // ]);
        $rules    = [
            'token'                     => ['required', new \Bageur\Auth\Rules\checkForgetToken],
            'password'                  => 'required|confirmed|min:6',
            'password_confirmation'     => 'required|min:6',
        ];

        $messages = [
        ];

        $attributes = [
        ];
        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $err = [];
            foreach ($rules as $key => $value) {
                if ($errors->has($key)) {
                    $err[$key] = ['text' => $errors->first($key) , 'status' => 'is-danger'];
                }else{
                    $err[$key] = ['text' => '' , 'status' => 'is-success'];
                }
            }
            return response(['status' => false , 'err' => $err],200);
        }else{
            $passwordReset  = password_reset::where('token', $request->token)->first();
            $user           = user::where('email', $passwordReset->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            $passwordReset->delete();
            $user->notify(new PasswordResetSuccess($passwordReset));
            return response(['status' => true ,'text'    => 'has input'], 200); 

        }
    }
}
