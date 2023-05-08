<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{
    use HasFactory;

    
    public  $timestamps = false;
    protected $table = 'frases';
    protected $primaryKey = 'id';

    protected $fillable = [
       'frase',
       'fraseClasica',
       'fraseModerna',
       'video',
       'estado'
    ];
}
