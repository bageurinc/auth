<?php
namespace Bageur\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Auth\model\user;
use Bageur\Auth\model\bageur_akses;
use Bageur\Auth\model\deviceregister;
use Bageur\Company\model\company;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
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
            if(! $token = Auth::attempt([$fieldType => $input['email'], 'password' => $input['password']])){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
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
              $listing[$rs->link.'-delete'] = $raa->granted == 0 ? false : true;
            }else{
              $listing[$raa->route] = $raa->granted == 0 ? false : true;
            }
          }
        }

        foreach ($rd->action as $a => $ra) {
         if($ra->nama == 'delete'){
              $listing[$rd->link.'-delete'] = $ra->granted == 0 ? false : true;
            }else{
              $listing[$ra->route] = $ra->granted == 0 ? false : true;
            }
        }

      }

      $menu        = bageur_akses::with(['sub_menu' => function($query){
                            $query->where('granted','1');
                     }])->whereNull('sub_id')->where('granted','1')
                        ->where('id_level',$id_level)
                        ->orderBy('urutan','asc')
                        ->get();

      $perusahaan = company::find(1);

        return response()->json([
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
            'fcmtoken'         => 'required|unique:\Bageur\Auth\model\deviceregister,token',
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
}