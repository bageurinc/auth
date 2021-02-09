<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
class bageur_akses_action extends Model
{
    protected $table   = 'bageur_akses_action';
    protected $appends = ['is_granted'];
    protected $hidden = [
        'granted'
    ];
    public function getIsGrantedAttribute()
    {
        if($this->granted == '1'){
            return true;
        }else{
            return false;
        }
    }
}
