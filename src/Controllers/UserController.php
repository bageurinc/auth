<?php
namespace Bageur\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Bageur\Auth\Model\user;
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
            $admin              		= new user;
            $admin->id_level	        = $request->id_level;
            $admin->username	        = $request->username;
            $admin->name                = $request->name;
            $admin->email               = $request->email;
            if(!empty($request->file)){
                $upload                           = \Bageur::base64($request->file,'admin');
                $admin->foto                      = $upload['up'];
                $admin->foto_path                 = $upload['path'];
            }

            if(!empty($request->file2)){
                $ds                               = \Bageur::base64($request->file2,'photos');
                // $admin->foto                      = $upload['up'];
            }

            if(!empty($request->file3)){
                $dsm                              = \Bageur::base64($request->file3,'photos');
                // $admin->foto                      = $upload['up'];
            }
            
            $admin->addons                      = json_encode(['userkode'                  => @$request->userkode,
                                                               'digital_signature'         => @$ds['up'],
                                                               'digital_signature_materai' => @$dsm['up']]);
            $admin->password                    = Hash::make($request->password);
            $admin->save();

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
            $admin              		= user::superadmin()->findOrFail($id);
            $admin->id_level	        = $request->id_level;
            $admin->username	        = $request->username;
            $admin->name                = $request->name;
            $admin->email               = $request->email;
            if(!empty($request->file)){
                $upload                           = \Bageur::base64($request->file,'admin');
                $admin->foto                      = $upload['up'];
                $admin->foto_path                 = $upload['path'];
            }
            $dsup = null;
            if(!empty($request->file2)){
                $ds                               = \Bageur::base64($request->file2,'photos');
                $dsup                             = @$ds['up'];
                // $admin->foto                      = $upload['up'];
            }else{
                $dsup                             = @$admin->addons_data->digital_signature;
            }
            $dsmup = null;
            if(!empty($request->file3)){
                $dsm                             = \Bageur::base64($request->file3,'photos');
                $dsmup                           = @$dsm['up'];
                // $admin->foto                      = $upload['up'];
            }else{
                $dsmup                           = @$admin->addons_data->digital_signature_materai;
            }
            $admin->addons              = json_encode(['userkode'                  => @$request->userkode,
                                                       'digital_signature'         => @$dsup,
                                                       'digital_signature_materai' => @$dsmup]);

            $admin->password            = Hash::make($request->password);
            $admin->save();
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