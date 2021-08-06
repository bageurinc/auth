<?php
namespace Bageur\Auth\Facades;

class Bageur {

	public function avatar($nama,$namafile=null,$path=null){
		if($namafile == null){
			if($nama){
				return @\Avatar::create(strtoupper($nama))->toBase64()->encoded;
			}else{
				return null;
			}
		}else{
			// $addpath = 'storage/';
			// return url($addpath.$path.'/'.$namafile);
			return \Storage::url($path.'/'.$namafile);
		}
	}

	public function textarea($text){
			$doc = new \DOMDocument();
            $doc->loadHTML("<div>$text</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $searchNode = $doc->getElementsByTagName( "img" );
            $img = [];
            foreach( $searchNode as $searchNode )
            {
				$val['file'] = $searchNode->getAttribute('src');
				$request = new \Illuminate\Http\Request($val);
				$validator = \Validator::make($request->all(), [
					'file' => 'required|base64image'
				]);

				if (!$validator->fails()) {
					$upload = \Bageur::base64($request->file,'_artikel_konten');
					$searchNode->setAttribute('src', \Bageur::avatar('xx',$upload['up'],$upload['path']));
				}
            }

			return $doc->saveHTML();
	}

	public function tglindo($date){
		\Carbon\Carbon::setLocale('id');
		return \Carbon\Carbon::parse($date)->format('d F Y');
    }

	public function toText($text){
         $d = new \Html2Text\Html2Text($text);
         return $d->getText();
    }

    public function blob($data,$loc,$id_user = null) {
    	$path       = $loc;
	    $namaBerkas = rand(000,999).'-'.$data->getClientOriginalName();
	    if($id_user != null){
	        $user   = \Bageur\Auth\Model\user::findOrFail($id_user);
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

	    $namaBerkas = $prefix.'-'.rand(000,999).date('ymdhis').'.'.$extension;
        $file = $path.'/'.$namaBerkas;
	    // $file = storage_path('app/public/'.$path.'/'.$namaBerkas);
	    // file_put_contents($file, $file_base64);
        \Storage::put($file, $file_base64);
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

			   $upload = \Bageur\Auth\Model\upload::query();
			   $upload->where('folder',$folder);
			   if($type == 'group'){
			   	  $upload->where($type,$id);
			   }else{
				  $upload->where('uuid',$id);
			   }
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
					$data =  $upload->first();
					return @$data->info;
			   }
	}
}
