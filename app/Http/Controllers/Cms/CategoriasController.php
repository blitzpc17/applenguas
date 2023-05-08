<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Session;
use App\Models\Categoria;
use App\Models\ItemCategoria;
use App\Models\User;

class CategoriasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function categorias(){
        $user = Auth::user();
        return view('cms.categorias',compact('user'));
    }

    public function listar(){
        return DB::table('categorias')->select('id', 'logo', 'nombre', 'descripcion', 'estado')->orderby('id')->get();
    }

    public function obtener(Request $r){
        
        $categoria = DB::table('categorias')->where('id', $r->id)->select('id', 'logo', 'nombre', 'descripcion', 'estado')->first();
        $items = DB::table('categorias as cat')
                    ->join('categorias_items as items', 'cat.id', 'items.categoriasid')
                    ->select('cat.Id as CategoriaId', 'items.Id as ItemId', 'items.palabraOriginal', 'items.TraduccionClasica', 'items.TraduccionModerna', 'items.img', 'items.pronunciacion', 'items.estado')
                    ->get();
        $data = array("cat" => $categoria, "items"=>$items);

        return response()->json($data);
    }

    public function save(Request $r){

        if($r->op!="R"){
            if(empty($r->nombre) || $r->nombre==null){
                return response()->json(["code"=>505, "msj"=>"*El campo nombre de la categoría es obligatorio.", "alerttype"=>"warning", "ctrl" => "nombre"]);
            }
    
            if(empty($r->descripcion) || $r->descripcion==null){
                return response()->json(["code"=>505, "msj"=>"*El campo descripción es obligatorio.", "alerttype"=>"warning", "ctrl" => "descripcion"]);
            }        
    
            if($r->op=='I'){
                if(empty($r->imagen) || $r->imagen==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo imagen es obligatorio.", "alerttype"=>"warning", "ctrl" => "imagen"]);
                }
            }
        }
      

       
        if($r->op == "I"){

            $image =  $r->file('imagen');           
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/img/categorias'), $new_name);

            $data = [
                "nombre" => $r->nombre,
                "logo" => $new_name,
                "estado" => 1,
                "descripcion" => $r->descripcion
            ];

            Categoria::create($data);

        }else{
            if($r->op == "M"){
                $data = [                
                    "nombre" => $r->nombre,                   
                    "estado" => 1,
                    "descripcion" => $r->descripcion               
                ];

                if($r->imagen!=null){
                    $categorias = Categoria::where('id', $r->id)->first();
                    $image =  $r->file('imagen');  
                    if($image!=null){
                        $new_name = $categorias->logo;
                        $image->move(public_path('frontend/img/categorias'), $new_name);            
                        array_merge($data, array( "logo" => $new_name));
                    }         
                  
                }    
             
            }else{
                $data = ["estado" => $r->edo];
            }
           

            Categoria::where('id', $r->id)->update($data);

        }

        return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente.", "alerttype"=>"success"]);


    }

    public function items(Request $r){
        $user = Auth::user();
        $categorias = Categoria::get();
        return view('cms.items',compact('user', 'categorias'));
    }

    public function listaritemscategorias(){

        return DB::table('categorias as cat')
            ->join('categorias_items as it', 'cat.id', 'it.categoriasId')
            ->select('cat.Id as CategoriaId', 'cat.nombre as CategoriaNombre', 
            'it.id', 'it.palabraOriginal as palabra', 'it.traduccionClasica as clasica', 'it.traduccionModerna as moderna', 'it.estado')
            ->get();

    }

    public function obteneritem(Request $r){
        $data =  DB::table('categorias as cat')
            ->join('categorias_items as it', 'cat.id', 'it.categoriasId')
            ->where('it.Id', $r->id)
            ->select('cat.Id as CategoriaId', 'cat.nombre as CategoriaNombre', 
            'it.id', 'it.palabraOriginal as palabra', 'it.traduccionClasica as clasica', 'it.traduccionModerna as moderna', 'it.estado')            
            ->first();
        return json_encode($data);
    }

    public function saveitem(Request $r){
        if($r->op!="R"){

            if(empty($r->categoria) || $r->categoria==null){
                return response()->json(["code"=>505, "msj"=>"*El campo categoría es obligatorio.", "alerttype"=>"warning", "ctrl" => "nombre"]);
            }

            if(empty($r->palabra) || $r->palabra==null){
                return response()->json(["code"=>505, "msj"=>"*El campo palabra es obligatorio.", "alerttype"=>"warning", "ctrl" => "nombre"]);
            }
    
            if(empty($r->clasica) || $r->clasica==null){
                return response()->json(["code"=>505, "msj"=>"*El campo traducción clásica es obligatorio.", "alerttype"=>"warning", "ctrl" => "descripcion"]);
            }

            if(empty($r->moderna) || $r->moderna==null){
                return response()->json(["code"=>505, "msj"=>"*El campo traducción moderna es obligatorio.", "alerttype"=>"warning", "ctrl" => "descripcion"]);
            }
           
    
            if($r->op=='I'){
                if(empty($r->img) || $r->img==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo imagen es obligatorio.", "alerttype"=>"warning", "ctrl" => "img"]);
                }

                if(empty($r->pronunciacion) || $r->pronunciacion==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo pronunciacion es obligatorio.", "alerttype"=>"warning", "ctrl" => "pronunciacion"]);
                }
            }
        }
      

       
        if($r->op == "I"){

            $image =  $r->file('img');           
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/img/itemcategorias'), $new_name);


            $image_pro =  $r->file('pronunciacion');           
            $new_name_pro = rand() . '.' . $image_pro->getClientOriginalExtension();
            $image_pro->move(public_path('frontend/img/itemcategorias'), $new_name_pro);


            $data = [
                "palabraOriginal" => $r->palabra,
                "img" => $new_name,
                "pronunciacion" => $new_name_pro,
                "TraduccionClasica" => $r->clasica,
                "TraduccionModerna" => $r->moderna,
                "estado" => 1,
                "categoriasId" => $r->categoria
            ];

            ItemCategoria::create($data);

        }else{
            if($r->op == "M"){
                $data = [                
                    "palabraOriginal" => $r->palabra,                  
                    "TraduccionClasica" => $r->clasica,
                    "TraduccionModerna" => $r->moderna,                  
                    "categoriasId" => $r->categoria          
                ];

                $item = DB::table('categorias_items')->where('id', $r->id)->first();

                if($r->img!=null){

                    $image =  $r->file('img');           
                    if($image!=null){
                        $new_name = $item->img;
                        $image->move(public_path('frontend/img/itemcategorias'), $new_name);   
                        array_merge($data, array( "img" => $new_name));
                    }
                }  

                if($r->pronunciacion!=null){

                    $image_pro =  $r->file('pronunciacion');  
                    if($image_pro!=null){
                        $new_name_pro = $item->pronunciacion;
                        $image_pro->move(public_path('frontend/img/itemcategorias'), $new_name_pro);            
                        array_merge($data, array( "pronunciacion" => $new_name_pro));
                    }         
                    
                } 
             
            }else{
                $data = ["estado" => $r->edo];
            }
           

            ItemCategoria::where('id', $r->id)->update($data);

        }

        return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente.", "alerttype"=>"success"]);

    }


}
