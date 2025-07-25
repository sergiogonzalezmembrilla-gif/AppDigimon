<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intercambio extends Model
{
    use HasFactory;

    protected $table = 'intercambios';

    protected $fillable = [
        'id_usuario',
        'id_digimon_ofrecido',
        'id_digimon_buscado',
        'id_digimon_recibido',
        'realizado'
    ];

    public function usuario()
{
    return $this->belongsTo(\App\Models\Usuario::class, 'id_usuario');
}

    public function digimonOfrecido()
    {
        return $this->belongsTo(Digimon::class, 'id_digimon_ofrecido');
    }

    public function digimonBuscado()
    {
        return $this->belongsTo(ListaDigimon::class, 'id_digimon_buscado');
    }
    public function digimonRecibido()
{
    return $this->belongsTo(Digimon::class, 'id_digimon_recibido');
}
}
