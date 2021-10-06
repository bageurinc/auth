<?php

namespace Bageur\Auth\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Bageur\Auth\Processors\Helper;

class user extends Authenticatable implements JWTSubject
{
    protected $table   = 'bgr_user';
    protected $appends = ['avatar','addons_data','digital_signature_url','digital_signature_materai_url'];
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute() {
        return \Bageur::avatar(@$this->name, @$this->foto, @$this->foto_path);
        //  if(!empty($this->foto)){
        //     return \Storage::url(@$this->foto_path.'/'.@$this->foto);
        // }else{
        //     return \Bageur::avatar($this->name);
        // }
    }

    public function getDigitalSignatureUrlAttribute() {
        return \Bageur::avatar(null,@$this->addons_data->digital_signature,'photos');
    }


    public function getDigitalSignatureMateraiUrlAttribute() {
        return \Bageur::avatar(null,@$this->addons_data->digital_signature_materai,'photos');
    }

    public function level()
    {
         return $this->hasOne('Bageur\Auth\Model\level','id','id_level');
    }

    public function getAddonsDataAttribute() {
        return json_decode($this->addons);
    }
     public function scopeSuperadmin($query)
    {
        $super_admin = \Auth::user()->level->super_admin;
        if($super_admin != 1){
           $query->where('super_admin',0);
        }
    }
    public function scopeDatatable($query,$request,$page=12)
    {

        $search       = ["name",'email','username'];
        $searchqry    = '';
        $searchqry = "(";
        // $query->join('bgr_level','bgr_level.id','bgr_user.id_level');
        // $query->select('bgr_user.*','bgr_level.nama');
        // $query->where('bgr_level.super_admin','!=',1);
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        }
        $searchqry .= ")";
        if(@$request->sort_by){
            if(@$request->sort_by != null){
                $explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }

        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }

}
