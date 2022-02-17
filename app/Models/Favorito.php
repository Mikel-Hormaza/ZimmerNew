<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Favorito extends Model {
    
    use HasFactory;

    protected $table = 'favoritos';

    public function User() {
        return $this->belongsTo(User::class);
    }

}
