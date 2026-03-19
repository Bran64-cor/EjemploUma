<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios'; 
    
    // Si tu tabla NO tiene las columnas created_at y updated_at, descomenta la siguiente línea:
    // public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'email',
        'telefono',
        'activo',
        'password' // <--- Agrega esto
    ];
    
    public function roles()
    {
        // Asegúrate de que el modelo Rol exista en App\Models\Rol
        return $this->belongsToMany(Rol::class, 'usuario_rol', 'usuario_id', 'rol_id');
    }
}