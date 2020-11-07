<?php
namespace Bageur\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Bageur\Auth\model\action;
use Bageur\Auth\model\level_akses;
use Bageur\Auth\model\level_akses_action;
class MenuActionController extends Controller
{

    public function index(Request $request)
    {
       $query = action::where('menu_id',$request->id)->datatable($request);
       return $query;
    }

    public function store(Request $request,$id)
    {
        if($request->delete){
            if(action::where('menu_id',$id)->where('nama','delete')->count() > 0){
                return response(['status' => false ,'text'    => 'tidak bisa 2x'], 200); 
            }else{
                $action                     = new action;
                $action->menu_id            = $id;
                $action->nama               = 'delete';
                $action->icon               =  'delete-circle';
                $action->save();
                
                if(level_akses::where('id_menu',$id)->count()){
                  foreach (level_akses::where('id_menu',$id)->get() as $key => $value) {
                        $new                 = new level_akses_action;
                        $new->id_level_akses = $value->id;
                        $new->id_action      = $action->id;
                        $new->granted        = false;
                        $new->save();
                  }
                }
            }
                return response(['status' => true ,'text'    => 'has input'], 200); 
        }else{
            $rules    	= [
                            'nama'                  => 'required|min:3',
                            'icon'                  => 'required',
                            'route'                 => 'required'
                          ];

            $messages 	= [];
            $attributes = [];

            $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response(['status' => false ,'error'    =>  $errors->all()], 200);
            }else{
                $action              		    = new action;
                $action->menu_id	          = $id;
                $action->nama               = $request->nama;
                $action->icon               = $request->icon;
                $action->route              = $request->route;
                $action->status             = $request->status;
                $action->save();
                if(level_akses::where('id_menu',$id)->count()){
                  foreach (level_akses::where('id_menu',$id)->get() as $key => $value) {
                        $new                 = new level_akses_action;
                        $new->id_level_akses = $value->id;
                        $new->id_action      = $action->id;
                        $new->granted        = false;
                        $new->save();
                  }
                }
                return response(['status' => true ,'text'    => 'has input'], 200); 
            }
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
        return action::findOrFail($id);
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
        $rules      = [
                        'nama'                  => 'required|min:3',
                        'icon'                  => 'required',
                        'route'                 => 'required'
                      ];

        $messages   = [];
        $attributes = [];

        $validator = \Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $action                   = action::findOrFail($id);
            $action->nama               = $request->nama;
            $action->icon               = $request->icon;
            $action->route               = $request->route;
            $action->status               = $request->status;
            $action->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($root,$id)
    {
          $delete = action::findOrFail($id);
          $delete->delete();
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}