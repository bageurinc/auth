<?php
namespace Bageur\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Bageur\Auth\model\menu;
use Bageur\Auth\model\level;
use Bageur\Auth\model\level_akses;
use Bageur\Auth\model\level_akses_action;
use Bageur\Auth\model\bageur_akses;
class LevelController extends Controller
{

    public function index(Request $request)
    {
       $query = level::where('super_admin',0)->datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'nama'                  => 'required|min:3'
                      ];

        $messages 	= [];
        $attributes = [];

        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $level              		= new level;
            $level->nama	            = $request->nama;
            $level->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return level::where('super_admin',0)->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $rules     = [
                        'nama'                  => 'required|min:3'
                      ];

        $messages   = [];
        $attributes = [];

        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $level                   = level::findOrFail($id);
            $level->nama             = $request->nama;
            $level->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delete = level::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

    public function bageur_akses(Request $request,$id){
        // $super_admin = \Auth::user()->level->super_admin;
        // return $super_admin;
        if(level_akses::where('id_level',$id)->count() > 0){
            return bageur_akses::with(['sub_menu' =>function($query){
               $query->superadmin();
            },'action'])
                               ->orderBy('urutan','asc')
                               ->whereNull('sub_id')
                               ->superadmin()
                               ->where('id_level',$id)
                               ->get();
        }else{
            return  menu::select('*','id as menu_id')->orderBy('urutan','asc')->with(['sub_menu' => function($query){
                $query->select('*','id as menu_id');
                $query->superadmin();
            },'action'])->superadmin()->whereNull('sub_id')->get();
        }
    }
    public function setup(Request $request,$id)
    {
        
        $delete = level_akses::where('id_level',$id)->delete();

        foreach ($request->all() as $key => $value) {
            $level_akses                = new level_akses;
            $level_akses->id_level      = $id; 
            $level_akses->id_menu       = $value['menu_id']; 
            $level_akses->granted       = @$value['is_granted'] == null ? false : true;
            $level_akses->save();

            foreach ($value['action'] as $ii => $a) {
                $action                    = new level_akses_action;
                $action->id_action         = $a['id']; 
                $action->id_level_akses    = $level_akses->id; 
                $action->granted           = @$a['is_granted'] == null ? false : true;
                $action->save();
            }

            foreach ($value['sub_menu'] as $i => $v) {
                $sub                = new level_akses;
                $sub->id_level      = $id; 
                $sub->id_menu       = $v['menu_id']; 
                $sub->sub_id        = $level_akses->id;
                $sub->granted       = @$v['is_granted'] == null ? false : true;
                $sub->save();

                foreach ($v['action'] as $iii => $aa) {
                    $action2                    = new level_akses_action;
                    $action2->id_action         = $aa['id']; 
                    $action2->id_level_akses    = $sub->id; 
                    $action2->granted           = @$aa['is_granted'] == null ? false : true;
                    $action2->save();
                }

            }
        }
        return response(['status' => true ,'text'    => 'has input'], 200); 
        
    }

}