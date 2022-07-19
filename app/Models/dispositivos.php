<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dispositivos extends Model
{
    use HasFactory;

    protected $table = "dispositivos";
    protected $fillable = ['user_id', 'producto_id', 'desaparecido', 'serie'];
}
