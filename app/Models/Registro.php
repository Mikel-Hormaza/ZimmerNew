<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    public function User() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'fecha_entrada',
        'fecha_salida',
    ];
}
