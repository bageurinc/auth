<?php

namespace Bageur\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bageur\Auth\model\level;
use Auth;

class MenuController extends Controller
{

    public function __construct()
    {
         // Auth::setDefaultDriver('bageur'); 
    }

    public function menufull()
    {
        $json = level::with(['fullmenu'])->find(Auth::user()->id_level);
        $json['fullmenu']->each(function ($q) {
            $q->append('avatar');
         });
        return $json['fullmenu'];
    }    

}
