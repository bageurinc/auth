<?php
namespace Bageur\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Auth\model\ind_provinsi;
use Bageur\Auth\model\ind_kota;
class IndonesiaController extends Controller
{

    public function provinsi()
    {
       $query = ind_provinsi::get();
       return $query;
    }
    public function provinsi_detail($id)
    {
       $query = ind_kota::where('id_prov',$id)->get();
       return $query;
    }

}