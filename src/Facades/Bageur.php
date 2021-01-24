<?php
namespace Bageur\Auth\Facades;

class Bageur {

	public function avatar($nama,$namafile=null,$path=null){
		if($namafile == null){
			return \Avatar::create($nama)->toBase64()->encoded;
		}else{
			$addpath = 'storage/';
			return url($addpath.$path.'/'.$namafile);
		}
	}
	public function tglindo($date){
		\Carbon\Carbon::setLocale('id');
		return \Carbon\Carbon::parse($date)->format('d F Y');
    }

    public function blob($data,$loc,$id_user = null) {
    	$path       = $loc;
	    $namaBerkas = rand(000,999).'-'.$data->getClientOriginalName();
	    if($id_user != null){
	        $user   = \Bageur\Auth\model\user::findOrFail($id_user);
	        $path   = $user->username.'/'.$loc;
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
	    
	    if($extension == 'msword'){
	    	$extension = 'doc';
	    }
	    if($extension == 'vnd.openxmlformats-officedocument.wordprocessingml.document'){
	    	$extension = 'docx';
	    }

	    $file = storage_path('app/public/'.$path.'/'.$namaBerkas);
	    file_put_contents($file, $file_base64);
	    $arr = ['up' => $namaBerkas , 'path' => $path];
	    return $arr;
  }

public function base64_v2($data){
	    $file        = explode(";base64,", $data['base64']);
	    $extension   = explode(":", $file[0]);
	    $extension   = explode("/", $extension[1])[1];
		$path        = $data['folder'];
		 \Storage::makeDirectory('public/'.$path);
	    $file_base64 = base64_decode($file[1]);
	    $namaBerkas  = date('ymdhis').'-'.$data['name'];
	    $file 		 = storage_path('app/public/'.$path.'/'.$namaBerkas);
	    file_put_contents($file, $file_base64);
	    return $namaBerkas;
  }
    public function g_gambar($id,$folder,$cover=false,$type="group"){

		if($type == "group"){
			   $upload = \Bageur\Auth\model\upload::query();
			   $upload->where('folder',$folder);
			   $upload->where($type,$id);
	  		   $upload->orderBy('id','asc');
			   if($type == 'group'){
				   if($cover == true){
					$data =  $upload->first();
					return @$data->info;
				   }else{
					 $data = $upload->get();
					 $new  = [];
					 foreach ($data as $key => $value) {
						$new[]['image'] = $value->info['base64']; 
					 }
					 return $new;
				   }
			   }else{
					return $upload->first();
			   }
		}

	}
}
