<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Frase;
use App\Models\User;
use DB;
use Auth;

class FrasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $user = Auth::user();
        return view('cms.frases',compact('user'));
    }

    public function listar(){
        return Frase::get();
    }

    public function obtener(Request $r){
        
        $frase = Frase::where('id', $r->id)->first();
        return json_encode($frase);
    }

    public function save(Request $r){

        if($r->op!="R"){
            if(empty($r->frase) || $r->frase==null){
                return response()->json(["code"=>505, "msj"=>"*El campo Frase es obligatorio.", "alerttype"=>"warning", "ctrl" => "frase"]);
            }
    
            if(empty($r->clasica) || $r->clasica==null){
                return response()->json(["code"=>505, "msj"=>"*El campo Forma Clásica es obligatorio.", "alerttype"=>"warning", "ctrl" => "clasica"]);
            } 
            
            if(empty($r->moderna) || $r->moderna==null){
                return response()->json(["code"=>505, "msj"=>"*El campo Forma Moderna es obligatorio.", "alerttype"=>"warning", "ctrl" => "moderna"]);
            } 

    
            if($r->op=='I'){
                if(empty($r->video) || $r->video==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo video es obligatorio.", "alerttype"=>"warning", "ctrl" => "video"]);
                }
            }
        }
      

       
        if($r->op == "I"){

            $image =  $r->file('video');           
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend/img/frases'), $new_name);

            $data = [
                "frase" => $r->frase,
                "fraseClasica" => $r->clasica,
                "fraseModerna" => $r->moderna,
                "video" => $new_name,
                "estado" => 1
            ];


            Frase::create($data);

        }else{
            if($r->op == "M"){
                $data = [                
                    "frase" => $r->frase,     
                    "fraseClasica" => $r->clasica,   
                    "fraseModerna" => $r->moderna,                 
                    "estado" => 1            
                ];

              //  dd($data);

                if($r->img!=null){
                    $frases = Frase::where('id', $r->id)->first();
                    $img =  $r->file('video');  
                    if($img!=null){
                        $new_name = $frases->video;
                        $img->move(public_path('frontend/img/frases'), $new_name);            
                        array_merge($data, array( "video" => $new_name));
                    }         
                  
                }    
             
            }else{
                $data = ["estado" => $r->edo];
            }
           

            Frase::where('id', $r->id)->update($data);

        }

        return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente.", "alerttype"=>"success"]);


    }
}
