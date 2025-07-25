<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    public $timestamps = false; // Esto evita que use created_at y updated_at

    protected $fillable = [
        'nombreusuario',
        'correousuario',
        'contraseñausuario',
        'digimon_id', // digimon actual del usuario
        'digimones_adquiridos', 
        'dinero',
    ];

    // Relación con el modelo Digimon (un usuario puede tener un digimon)
    public function digimon()
    {
        // Actualiza la relación para usar digimon_id en lugar de id_usuario
        return $this->belongsTo(Digimon::class, 'digimon_id'); // Aquí usamos 'digimon_id' como clave foránea
    }
  
 public function intercambios()
{
    return $this->hasMany(Intercambio::class, 'id_usuario');
}
}
