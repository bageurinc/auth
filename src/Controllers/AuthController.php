<?php
namespace Bageur\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Auth\Model\user;
use Bageur\Auth\Model\bageur_akses;
use Bageur\Auth\Model\deviceregister;
use Bageur\Auth\Model\logs;
use Bageur\Company\Model\company;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $input = $request->all();
            $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            // return $input;
            if(! $token = Auth::attempt([$fieldType => $input['email'], 'password' => $input['password']])){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }

            $cekakun = user::where('email', $input['email'])->orWhere('username', $input['email'])->first();
            $logs = new logs;
            $logs->nama = $cekakun->name;
            $logs->save();

        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {

            if (! $user = Auth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $user = Auth::refresh();
        return $this->respondWithToken($user);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
     $id_level = Auth::user()->id_level;
     $data = bageur_akses::with(['sub_menu','action'])->whereNull('sub_id')->where('id_level',$id_level)->get();
      $listing = [];
      foreach ($data as $d => $rd) {
        $listing[$rd->link] = $rd->granted == 0 ? false : true;
        foreach ($rd->sub_menu as $a => $rs) {
         $listing[$rs->link] = $rs->granted == 0 ? false : true;
          foreach ($rs->action as $aa => $raa) {
            if($raa->nama == 'delete'){
              $listing[strtolower($rs->link.'-delete')] = $raa->granted == 0 ? false : true;
            }else{
              $listing[strtolower($raa->route)] = $raa->granted == 0 ? false : true;
            }
          }
        }

        foreach ($rd->action as $a => $ra) {
         if($ra->nama == 'delete'){
              $listing[strtolower($rd->link.'-delete')] = $ra->granted == 0 ? false : true;
            }else{
              $listing[strtolower($ra->route)] = $ra->granted == 0 ? false : true;
            }
        }

      }

      $menu['sidebar']        = bageur_akses::with(['sub_menu' => function($query){
                                        $query->where('granted','1');
                                }])->whereNull('sub_id')->where('granted','1')
                                    ->where('id_level',$id_level)
                                    ->where('posisi','sidebar')
                                    ->orderBy('urutan','asc')
                                    ->get();

      $menu['navbar']        = bageur_akses::with(['sub_menu' => function($query){
                                        $query->where('granted','1');
                                }])->whereNull('sub_id')->where('granted','1')
                                    ->where('id_level',$id_level)
                                    ->where('posisi','navbar')
                                    ->orderBy('urutan','asc')
                                    ->get();

      $perusahaan = company::find(1);

        return response()->json([
            'user'          => auth()->user(),
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'level_akses'   => $listing,
            'menu'          => $menu,
            'perusahaan'    => $perusahaan,
            'expires_in'    => auth()->factory()->getTTL() * 60
        ]);
    }

    public function device_add(Request $request){
        $rules    = [
            'fcmtoken'         => 'required|unique:\Bageur\Auth\Model\deviceregister,token',
        ];

        $messages = [
        ];

        $attributes = [
        ];
        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if (!$validator->fails()) {
            $new            = new deviceregister;
            $new->id_user   = @$request->user_id;
            $new->token     = @$request->fcmtoken;
            $new->topic     = @$request->topic;
            $new->save();
            return ['status' => true];
        }
    }

    public function getuserinfo()
    {
        // $db = user::where('id', Auth::user()->id)->first();
         return user::superadmin()->findOrFail(Auth::user()->id);
        // return $db;
    }

    public function edituser(Request $request)
    {
         $rules     = [
                        'name'                  => 'required|min:3',
                        'email'                 => 'required|unique:bgr_user,id,|email',
                        'username'              => 'required|unique:bgr_user,id,',
                        'userkode'              => 'required',
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
            $admin                      = user::where('id', Auth::user()->id)->first();
            $admin->username            = $request->username;
            $admin->name                = $request->name;
            $admin->email               = $request->email;
            $admin->jabatan               = $request->jabatan;
            $admin->tanggalmasuk               = $request->tanggalmasuk;
            $admin->nama_bank               = $request->nama_bank;
            $admin->no_rek               = $request->no_rek;
            $admin->jumlah_pinjaman               = $request->jumlah_pinjaman;
            $admin->sisa_pinjaman               = $request->sisa_pinjaman;
            $admin->pinjaman_belum_dibayar               = $request->pinjaman_belum_dibayar;
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
            if(!empty($request->password)){
                $admin->password            = Hash::make($request->password);
            }
            $admin->save();

            return response(['status' => $admin ,'text'    => 'has input'], 200);
        }
    }

}
