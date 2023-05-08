<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\User;
use DB;
use Auth;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $user = Auth::user();
        return view('cms.blog',compact('user'));
    }

    public function listar(){
        return DB::table('blog')->select('id', 'titulo', 'texto', 'img', 'estado')->orderby('id')->get();
    }

    public function obtener(Request $r)
    {        
        return json_encode(Blog::where('id', $r->id)->first());
    }

    public function save(Request $r){

        if($r->op!="R"){
            if(empty($r->titulo) || $r->titulo==null){
                return response()->json(["code"=>505, "msj"=>"*El campo titulo es obligatorio.", "alerttype"=>"warning", "ctrl" => "titulo"]);
            }
    
            if(empty($r->texto) || $r->texto==null){
                return response()->json(["code"=>505, "msj"=>"*El campo texto es obligatorio.", "alerttype"=>"warning", "ctrl" => "texto"]);
            }    
    
            if($r->op=='I'){
                if(empty($r->img) || $r->img==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo imagen es obligatorio.", "alerttype"=>"warning", "ctrl" => "img"]);
                }
            }
        }
      

       
        if($r->op == "I"){

            $image =  $r->file('img');           
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/img/blog'), $new_name);

            $data = [
                "titulo" => $r->titulo,
                "img" => $new_name,
                "estado" => 1,
                "texto" => $r->texto
            ];

            Blog::create($data);

        }else{
            if($r->op == "M"){
                $data = [                
                    "titulo" => $r->titulo,     
                    "estado" => 1,
                    "texto" => $r->texto     
                ];

                if($r->img!=null){
                    $blog = Blog::where('id', $r->id)->first();
                    $image =  $r->file('img');  
                    if($image!=null){
                        $new_name = $blog->img;
                        $image->move(public_path('frontend/img/blog'), $new_name);            
                        array_merge($data, array( "img" => $new_name));
                    }         
                  
                }    
             
            }else{
                $data = ["estado" => $r->edo];
            }
           

            Blog::where('id', $r->id)->update($data);

        }

        return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente.", "alerttype"=>"success"]);


    }
}
