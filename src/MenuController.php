<?php

namespace Bageur\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bageur\Auth\model\level;
use Bageur\Auth\model\menu;
use Bageur\Auth\model\bageur_akses;
use Bageur\Auth\model\level_akses;
use Auth,Validator,DB;

class MenuController extends Controller
{

    public function __construct()
    {
         // Auth::setDefaultDriver('bageur'); 
    }

    public function menufull()
    {
        $json = Menu::with(['sub_menu'])->orderby('urutan','asc')->whereNull('sub_id')->get();
        return $json;
        // $json = level::with(['fullmenu'])->find(Auth::user()->id_level);
        // $json['fullmenu']->each(function ($q) {
        //     $q->append('avatar');
        //  });
        // return $json['fullmenu'];
    }    
    public function notif()
    {
        $json = DB::table('notifications')->limit(10)->get();
        foreach($json as $r){
            $r->data_json = json_decode($r->data);
        }
        return $json;
    }
    public function notif_detail($id)
    {
        $json = DB::table('notifications')->where('id',$id)->first();
        $json->data_json = json_decode($json->data);
        return response()->json($json);
    }
     public function urutankan(Request $request)
    {

        $up         = menu::find($request->id);
        $up->urutan = $request->urutan_baru;
        $up->update();

        $up2        = menu::find($request->id_old);
        $up2->urutan = $request->urutan_sekarang;
        $up2->update();
    }
    public function index(Request $request)
    {
         $menu =  menu::with(['sub_menu','action'])->datatable($request,30);
         $menu->each(function ($q) {
            $q->append('avatar');
            $q->append('banyaksub');
         });
         return $menu;
    }
    public function show($id)
    {
       $menu         = menu::find($id);
       return $menu;
    }
    public function showseo($seo_link)
    {
       $id_level = Auth::user()->id_level;
       $menu         = bageur_akses::with(['sub_menu' => function($query){
                                        $query->where('granted','1');
                                     }])
                                   ->where('granted','1')
                                   ->where('id_level',$id_level)
                                   ->where('seo_link',$seo_link)
                                   ->firstOrFail();
       return $menu;
    }

   public function ubahstatus(Request $request)
   {
        $edit         = menu::find($request->id);
        $edit->status = $request->status; 
        $edit->save();      

        return response(['status' => true], 200); 
   }
   
    public function store(Request $request)
    {
       $rules    = [
                        'nama'    => 'required',
                        'judul'   => 'required',
                        'link'    => 'required',
                        'files'    => 'nullable|mimes:svg,png|max:50',
                    ];
        $messages = [
        ];

        $attributes = [
        ];
        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $menu             = new menu;
            if(!empty($request->sub_id)){
                $menu->sub_id       = $request->sub_id;
                $menu->urutan     = @menu::where('sub_id',$request->sub_id)->latest('urutan')->first()->urutan+1;
            }else{
                $menu->urutan     = @menu::latest('urutan')->first()->urutan+1;
            }
            $menu->nama       = $request->nama;
            $menu->judul      = $request->judul;
            $menu->link       = $request->link;
            $menu->seo_link   = Str::slug($request->link);
            if($request->file('files') != null){
                $menu->icon     = \Bageur::blob($request->file('files'),'iconmenu')['up'];
            }
            $menu->save();

          foreach (level_akses::groupBy('id_level')->get() as $key => $value) {
                $new                 = new level_akses;
                $new->id_level       = $value->id_level;
                if(!empty($request->sub_id)){
                    $new->id_menu      = $menu->id;
                    $new->sub_id       = level_akses::where('id_level',$value->id_level)->where('id_menu',$request->sub_id)->first()->id;
                }else{
                    $new->id_menu      = $menu->id;
                }
                $new->save();
          }

            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }
    public function update($id,Request $request)
    {
       $rules    = [
                        'nama'    => 'required',
                        'judul'   => 'required',
                        'files'    => 'nullable|mimes:svg,png|max:50',
                    ];
        if($request->file('files') != null){
            $rules['files'] = 'mimes:svg,png|max:50';
        }   
        $messages = [
        ];

        $attributes = [
        ];
        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $menu             = menu::find($id);
            if(!empty($request->sub_id)){
                $menu->sub_id       = $request->sub_id;
                // $menu->urutan     = @menu::where('sub_id',$request->sub_id)->latest('urutan')->first()->urutan+1;
            }else{
                // $menu->urutan     = @menu::whereNull('sub_id')->latest('urutan')->first()->urutan+1;
            }
            $menu->nama       = $request->nama;
            $menu->judul      = $request->judul;
            $menu->link       = $request->link;
            $menu->seo_link   = Str::slug($request->link);
            if($request->file('files') != null){
                $menu->icon     = \Bageur::blob($request->file('files'),'iconmenu')['up'];
            }
            $menu->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }
    public function destroy($id)
    {
        $delete = menu::findOrFail($id);
        $delete->delete();
        return response(['status' => true ,'text'    => 'deleted'], 200); 
    }
}
