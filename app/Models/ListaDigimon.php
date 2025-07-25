<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDigimon extends Model
{
    public $timestamps = false; // Desactiva los timestamps si no los necesitas
    
    use HasFactory;

    // Definir la tabla asociada a este modelo
    protected $table = 'lista_digimon';

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'nivel',
        'ataquebase',
        'defensabase',
        'vidabase',
        'experienciabase',
        'experienciaactual',
        'experienciasiguientenivel',
        'idevolucion',
        'idinvolucion',
        'etapa',
        'videogif',
        'elemento',
        'idevolucion2',
        'idinvolucion2',
        'idevolucion3',
        'idinvolucion3',
        'descripcion',
    ];

    
    // Relación con los Digimon creados por los usuarios (si aplica)
    public function digimons()
    {
        return $this->hasMany(Digimon::class, 'id_lista_digimon');
    }

     // Métodos para calcular la vida, ataque y defensa actuales
     public function vidaActual()
     {
         return $this->vidabase + ($this->nivel * 5);
     }
 
     public function ataqueActual()
     {
         return $this->ataquebase + ($this->nivel * 2);
     }
 
     public function defensaActual()
     {
         return $this->defensabase + ($this->nivel * 2);
     }
}
