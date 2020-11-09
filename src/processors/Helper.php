<?php
namespace Bageur\Auth\Processors;

class Helper {

    public static function avatar( $name, $image = null, $folder = "bageur", $type = "initials") {
        if (empty($image)) {
            if (!empty($name)) {
                return 'https://avatars.dicebear.com/v2/'.$type.'/' . preg_replace('/[^a-z0-9 _.-]+/i', '', $name) . '.svg';
            }
            return null;
        }
        return url('bageur.id/'.$image);
    }

    public static function go($data,$loc,$id_user = null) {
       // $namaBerkas = date('YmdHis').'.'.$data->getClientOriginalExtension();
       // $path = $data->storeAs('public/'.$loc.'/', $namaBerkas);
       // return basename($path);
    	$path       = 'bageur.id/'.$loc;
	    $namaBerkas = rand(000,999).'-'.$data->getClientOriginalName();
	    if($id_user != null){
	        $user   = \Bageur\Auth\model\user::findOrFail($id_user);
	        $path   = 'bageur.id/'.$user->username.'/'.$loc;
	        \Storage::makeDirectory('public/'.$path);
	    }
	    $up         = $data->storeAs('public/'.$path.'/', $namaBerkas);
	    $arr = ['up' => basename($up) , 'path' => $path];
	    return $arr;
    }

      function avatarbase64($data,$loc,$id_user = null,$prefix = 'bageur')
      {
        $path       = $loc;
        $namaBerkas = $prefix.'-'.date('ymdhis').'.png';
        if($id_user != null){
            $user   = \App\User::findOrFail($id_user);
            $path   = $user->username.'/'.$loc;
            \Storage::makeDirectory('public/'.$path);
        }
        $image = \Image::make($data);
        $image->save(storage_path('app/public/'.$path.'/'.$namaBerkas));
        $arr = ['up' => $namaBerkas , 'path' => $path];
        return $arr;
      }
}
