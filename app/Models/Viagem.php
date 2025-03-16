<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    use HasFactory;

    protected $table = 'viagens';

    protected $fillable = [
        'veiculo_id',
        'distancia',
        'data_hora_inicio',
        'data_hora_chegada',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function motoristas()
    {
        return $this->belongsToMany(Motorista::class, 'motorista_viagem');
    }
}
