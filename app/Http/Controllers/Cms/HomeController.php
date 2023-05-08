<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;
use Hash;
use Session;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){
        $user = Auth::user();
        return view('cms.dashboard',compact('user'));
    }

    public function usuarios(){
        $user = Auth::user();
        return view('cms.usuarios', compact('user'));
    }

    public function save(Request $r){

        if($r->op!="R"){
            if(empty($r->name) || $r->name==null){
                return response()->json(["code"=>505, "msj"=>"*El campo nombre de usuario es obligatorio.", "alerttype"=>"warning", "ctrl" => "name"]);
            }
    
            if(empty($r->email) || $r->email==null){
                return response()->json(["code"=>505, "msj"=>"*El campo email es obligatorio.", "alerttype"=>"warning", "ctrl" => "email"]);
            }
    
            if($r->op=='I'){
                if(empty($r->password) || $r->password==null){
                    return response()->json(["code"=>505, "msj"=>"*El campo contraseña es obligatorio.", "alerttype"=>"warning", "ctrl" => "password"]);
                }
                if(strcmp($r->password, $r->repass)!=0 && ($r->op=="I")){
                    return response()->json(["code"=>505, "msj"=>"*Las contraseñas no coinciden.", "alerttype"=>"warning", "ctrl" => "repass"]);
                }
            }else if($r->op=='M'){
                if(!empty($r->password) && empty($r->repass)){
                    return response()->json(["code"=>505, "msj"=>"*Debe reingresar su contraseña, para poder actualizar el registro.", "alerttype"=>"warning", "ctrl" => "repass"]);
                }
                if(strcmp($r->password, $r->repass)!=0 && ($r->op=="M")){
                    return response()->json(["code"=>505, "msj"=>"*Las contraseñas no coinciden.", "alerttype"=>"warning", "ctrl" => "repass"]);
                }
            }
        }
      

       
        if($r->op == "I"){

            $data = [

                "name" => $r->name,
                "email" => $r->email,
                "estado" => 1,
                "password" => Hash::make($r->password)
            ];

            User::create($data);

        }else{
            if($r->op == "M"){
                $data = [                
                    "name" => $r->name,
                    "email" => $r->email               
                ];
    
                if(!empty($r->password)){
                    $data = array_merge($data,array( "password" => Hash::make($r->password) ) );
                }
            }else{
                $data = ["estado" => $r->edo];
            }
           

            User::where('id', $r->id)->update($data);

        }

        return response()->json(["code"=>200, "msj"=>"Registro guardado correctamente.", "alerttype"=>"success"]);
    }

    public function listar(){
        return DB::table('users')->select('id', 'name', 'email', 'estado')->orderby('id')->get();
    }

    public function obtener(Request $r){
        return json_encode(DB::table('users')->where('id', $r->id)->select('id', 'name', 'email', 'estado')->first());
    }


}
