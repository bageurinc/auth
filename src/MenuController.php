<?php

namespace Bageur\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bageur\Auth\model\level;
use Bageur\Auth\model\menu;
use Auth,Validator;

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
         $menu =  menu::with(['sub_menu'])->datatable($request,30);
         $menu->each(function ($q) {
            $q->append('avatar');
            $q->append('banyaksub');
         });
         return $menu;
    }
    public function show($id)
    {
       $menu         = menu::find($id);
       // $menu->img    = route('getimg',['iconmenu',$menu->icon]);
       $menu->append('avatar');
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
            $menu             = new menu;
            $menu->nama       = $request->nama;
            $menu->judul      = $request->judul;
            $menu->action     = 'index';
            $menu->link       = $request->link;
            $menu->seo_link   = Str::slug($request->link);
            $menu->urutan     = @menu::latest('urutan')->first()->urutan+1;
            if($request->file('files') != null){
                @Storage::disk('local')->delete('public/iconmenu/'.$menu->gambar);
                 $SnameFile = time().'.'.$request->file('files')->getClientOriginalExtension();
                 Storage::disk('local')->putFileAs('public/'.'iconmenu', $request->file('files'),$SnameFile);
                $menu->icon     = $SnameFile;
            }
            $menu->save();
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }
    public function update($id,Request $request)
    {
       $rules    = [
                        'nama'    => 'required',
                        'judul'   => 'required',
                        'link'    => 'required',
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
            $menu->nama       = $request->nama;
            $menu->judul       = $request->judul;
            $menu->link       = $request->link;
            $menu->seo_link   = Str::slug($request->link);
            if($request->file('files') != null){
                @Storage::disk('local')->delete('public/iconmenu/'.$menu->gambar);
                 $SnameFile = time().'.'.$request->file('files')->getClientOriginalExtension();
                 Storage::disk('local')->putFileAs('public/'.'iconmenu', $request->file('files'),$SnameFile);
                $menu->icon     = $SnameFile;
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
