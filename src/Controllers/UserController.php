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
            $admin->hp                = $request->hp;
            $admin->email               = $request->email;
            $admin->jabatan               = $request->jabatan;
            $admin->tanggalmasuk               = $request->tanggalmasuk;
            $admin->nama_bank               = $request->nama_bank;
            $admin->no_rek               = $request->no_rek;
            $admin->nama_pemilik               = $request->nama_pemilik;
            $admin->jumlah_pinjaman               = $request->jumlah_pinjaman;
            $admin->sisa_pinjaman               = $request->sisa_pinjaman;
            $admin->pinjaman_belum_dibayar               = $request->pinjaman_belum_dibayar;
            // if(!empty($request->file)){
                // $upload                           = \Bageur::base64($request->file,'admin');
            $admin->foto                      = $request->foto;
            $admin->foto_path                 = $request->foto_path;
            // }

            // if(!empty($request->file2)){
                // $ds                               = \Bageur::base64($request->file2,'photos');
                // $admin->foto                      = $upload['up'];
            // }

            // if(!empty($request->file3)){
                // $dsm                              = \Bageur::base64($request->file3,'photos');
                // $admin->foto                      = $upload['up'];
            // }
            
            $admin->addons                      = json_encode(['userkode'                  => @$request->userkode,
                                                               'digital_signature'         => @$request->digital_signature,
                                                               'digital_signature_materai' => @$request->digital_signature_materai]);
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
        return user::superadmin()->with('level')->findOrFail($id);
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
            $admin->hp                = $request->hp;
            $admin->email               = $request->email;
            $admin->jabatan               = $request->jabatan;
            $admin->tanggalmasuk               = $request->tanggalmasuk;
            $admin->nama_bank               = $request->nama_bank;
            $admin->no_rek               = $request->no_rek;
            $admin->nama_pemilik               = $request->nama_pemilik;
            $admin->jumlah_pinjaman               = $request->jumlah_pinjaman;
            $admin->sisa_pinjaman               = $request->sisa_pinjaman;
            $admin->pinjaman_belum_dibayar               = $request->pinjaman_belum_dibayar;
            $admin->foto                      = $request->foto;
            $admin->foto_path                 = $request->foto_path;
            // $dsup = null;
            // if(!empty($request->file2)){
            //     $ds                               = \Bageur::base64($request->file2,'photos');
            //     $dsup                             = @$ds['up'];
            //     // $admin->foto                      = $upload['up'];
            // }else{
            //     $dsup                             = @$admin->addons_data->digital_signature;
            // }
            // $dsmup = null;
            // if(!empty($request->file3)){
            //     $dsm                             = \Bageur::base64($request->file3,'photos');
            //     $dsmup                           = @$dsm['up'];
            //     // $admin->foto                      = $upload['up'];
            // }else{
            //     $dsmup                           = @$admin->addons_data->digital_signature_materai;
            // }
            $admin->addons              = json_encode(['userkode'                  => @$request->userkode,
                                                       'digital_signature'         => @$request->digital_signature,
                                                       'digital_signature_materai' => @$request->digital_signature_materai]);
            if(!empty($request->password)){
                $admin->password            = Hash::make($request->password);
            }
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
