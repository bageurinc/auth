<?php
namespace Bageur\Auth\Facades;

class Bageur {

	public function avatar($nama,$namafile=null,$path=null){
		if($namafile == null){
			return \Avatar::create($nama)->toBase64()->encoded;
		}else{
			$addpath = null;
			if(env('APP_ENV') != 'local'){
				$addpath = 'storage/';
			}
			return url($addpath.$path.'/'.$namafile);
		}
	}
	public function tglindo($date){
		\Carbon\Carbon::setLocale('id');
		return \Carbon\Carbon::parse($date)->format('d F Y');
    }

    public function blob($data,$loc,$id_user = null) {
    	$path       = 'bageur.id/'.$loc;
	    $namaBerkas = rand(000,999).'-'.$data->getClientOriginalName();
	    if($id_user != null){
	        $user   = \Bageur\Auth\model\user::findOrFail($id_user);
	        $path   = 'bageur.id/'.$user->username.'/'.$loc;
	        \Storage::makeDirectory('public/'.$path);
	    }else{
	        \Storage::makeDirectory('public/'.$path);
	    }
	    $up         = $data->storeAs('public/'.$path.'/', $namaBerkas);
	    $arr = ['up' => basename($up) , 'path' => $path];
	    return $arr;
    }
    
    public function base64($data,$loc,$id_user = null,$prefix = 'bageur'){
	    $file        = explode(";base64,", $data);
	    $extension   = explode(":", $file[0]);
	    $extension   = explode("/", $extension[1])[1];
	    $path        = $loc;
	    $file_base64 = base64_decode($file[1]);
	    $namaBerkas = $prefix.'-'.date('ymdhis').'.'.$extension;
	    if($id_user != null){
	        $user   = \App\User::findOrFail($id_user);
	        $path   = $user->username.'/'.$loc;
	        \Storage::makeDirectory('public/'.$path);
	    }else{
		        \Storage::makeDirectory('public/'.$path);
		}
	    $file = storage_path('app/public/'.$path.'/'.$namaBerkas);
	    file_put_contents($file, $file_base64);
	    $arr = ['up' => $namaBerkas , 'path' => $path];
	    return $arr;
  }
   public function provinsi($id = null){
   		$provinsi = \Bageur\Auth\model\ind_provinsi::kondisi($id);
   		return $provinsi;
   }
}
