<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategoria extends Model
{
    use HasFactory;


    public  $timestamps = false;
    protected $table = 'categorias_items';
    protected $primaryKey = 'id';

    protected $fillable = [
       'palabraOriginal',
       'TraduccionClasica',
       'TraduccionModerna',
       'img',
       'pronunciacion',
       'estado',
       'categoriasId'
    ];
}
