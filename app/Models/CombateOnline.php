<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombateOnline extends Model
{
    use HasFactory;

    protected $table = 'combates_online';
    public $timestamps = false;


    protected $fillable = [
        'id_usuario',
        'id_digimon_defensor',
        'victorias',
        'derrotas',
        'empates',
        'clasificacion',
        'puntos',
        'usuarios_combatidos', 
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function digimon()
    {
        return $this->belongsTo(Digimon::class, 'id_digimon_defensor');
    }
}
