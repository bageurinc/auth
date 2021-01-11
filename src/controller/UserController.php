<?php
namespace Bageur\Auth\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Bageur\Auth\model\user;
use Bageur\Auth\Processors\Helper;
use Validator;
class UserController extends Controller
{

    public function index(Request $request)
    {
       $query = user::with('level')->superadmin()->datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules      = [
                        'name'                  => 'required|min:3',
                        'username'              => 'required|unique:bgr_user',
                        'email'                 => 'required|unique:bgr_user|email',
                        'password'              => 'required|min:3|confirmed',
                        'password_confirmation' => 'required',
                      ];

        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $user                   = new user;
            $user->id_level         = 1;
            $user->username         = $request->username;
            $user->name             = $request->name;
            $user->email            = $request->email;
             if(!empty($request->file)){
                $upload                          = Helper::avatarbase64($request->file,'admin');
                $user->foto                      = $upload['up']; 
                $user->foto_path                 = $upload['path']; 
            }     
            $user->password         = Hash::make($request->password);
            $user->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return user::superadmin()->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $rules     = [
                        'name'                  => 'required|min:3',
                        'email'                 => 'required|unique:bgr_user,id,'.$id.'|email',
                        'password'              => 'nullable|min:3|confirmed',
                        'password_confirmation' => 'nullable',
                      ];

        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $user                   = user::superadmin()->findOrFail($id);
            $user->name             = $request->name;
            $user->email            = $request->email;
             if(!empty($request->file)){
                $upload                          = Helper::avatarbase64($request->file,'admin');
                $user->foto                      = $upload['up']; 
                $user->foto_path                 = $upload['path']; 
            }     
            if(!empty($request->password)){
                $user->password         = Hash::make($request->password);
            }
            $user->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delete = user::superadmin()->findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}