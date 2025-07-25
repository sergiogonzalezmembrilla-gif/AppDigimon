<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digimon extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'digimon';

protected $fillable = [
    'id_usuario',
    'id_lista_digimon',
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
    'hambre',
    'salud',
    'caca',
    'higiene',
    'felicidad',
    'numentrenamientos',
    'bonoinvolucion',
    'ataqueentrenamiento',
    'defensaentrenamiento',
    'vidamaxentrenamiento',
    'night1',
    'light1',
    'machine1',
    'beast1',
    'bird1',
    'water1',
    'dragon1',
    'insect1',
    'night2',
    'light2',
    'machine2',
    'beast2',
    'bird2',
    'water2',
    'dragon2',
    'insect2',
    'night3',
    'light3',
    'machine3',
    'beast3',
    'bird3',
    'water3',
    'dragon3',
    'insect3',
    'numllave1',
    'numllave2',
    'numllavenecesaria1',
    'numllavenecesaria2',
    'num_evoluciones',
    'ocupado',
    'ocupado2',
];


    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación con ListaDigimon
    public function listaDigimon()
    {
        return $this->belongsTo(ListaDigimon::class, 'id_lista_digimon');
    }

    // Relación con Evoluciones (varias opciones)
    public function evolucion1()
    {
        return $this->belongsTo(ListaDigimon::class, 'idevolucion');
    }

    public function involucion1()
    {
        return $this->belongsTo(ListaDigimon::class, 'idinvolucion');
    }

    public function evolucion2()
    {
        return $this->belongsTo(ListaDigimon::class, 'idevolucion2');
    }

    public function involucion2()
    {
        return $this->belongsTo(ListaDigimon::class, 'idinvolucion2');
    }

    public function evolucion3()
    {
        return $this->belongsTo(ListaDigimon::class, 'idevolucion3');
    }

    public function involucion3()
    {
        return $this->belongsTo(ListaDigimon::class, 'idinvolucion3');
    }

    public function vidaActual()
{
    return $this->vidabase + ($this->nivel * 5) + ($this->vidamaxentrenamiento * 1) + ($this->felicidad * 0.2) + ($this->bonoinvolucion * 2);
}

public function ataqueActual()
{
    return $this->ataquebase + ($this->nivel * 2) + ($this->ataqueentrenamiento * 0.75) + ($this->felicidad * 0.1)+ ($this->bonoinvolucion);
}

public function defensaActual()
{
    return $this->defensabase + ($this->nivel * 2) + ($this->defensaentrenamiento * 0.75) + ($this->felicidad * 0.1)+ ($this->bonoinvolucion);
}

public function experienciaPorcentaje()
{
    if ($this->experienciasiguientenivel == 0) {
        return 100;
    }

    return round(($this->experienciaactual / $this->experienciasiguientenivel) * 100, 2);
}

// Calcular el porcentaje de experiencia completada
public function porcentajeExperiencia()
{
    if ($this->experienciasiguientenivel == 0) {
        return 100; // Si no hay experiencia necesaria, consideramos que está al 100%
    }

    return round(($this->experienciaactual / $this->experienciasiguientenivel) * 100, 2);
}
public function entrenamientosMaximos()
{
    return ($this->num_evoluciones + $this->bonoinvolucion) * 5;
}

public function haAlcanzadoPotencialMaximo()
{
    return ($this->num_evoluciones + $this->bonoinvolucion) > 50;
}

public function puedeEntrenar()
{
    return !$this->haAlcanzadoPotencialMaximo() && $this->numentrenamientos < $this->entrenamientosMaximos();
}

}
