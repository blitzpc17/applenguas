<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class CategoriasController extends Controller
{
    public function index(){
        $categorias = DB::table('categorias as cat')->get();
        return view('front.categorias', compact('categorias'));
    }

    public function mostraritemcategoria(Request $r){
        $categoria = DB::table('categorias as cat')->where('id', $r->cat)->first();
        $items = DB::table('categorias as cat')
                    ->join('categorias_items as it', 'cat.id', 'it.categoriasId')
                    ->select(DB::raw('it.*'))
                    ->where('categoriasId', $r->cat)->get();

        return view('front.items_categoria', compact('categoria', 'items'));
    }
}
