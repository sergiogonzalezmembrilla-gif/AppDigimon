<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaCancion extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si no sigue la convención
    protected $table = 'lista_canciones';

    // Si las columnas no siguen la convención de nombres, se definen explícitamente
    protected $fillable = [
        'nombre',
        'enlace',
    ];

    // Si no usas los campos de timestamp, deshabilítalos:
    public $timestamps = false;
}
