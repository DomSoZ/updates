<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $fillable = [

       'id_usuario',
       'linea_captura',
       'accion',
       'fecha'
   
    ];

    protected $table = 'bitacora';
}