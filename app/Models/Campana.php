<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{
    use HasFactory;

    protected $table = 'campanas';

    protected $fillable = [
        'nombre',
        'invitados',
        'fecha',
    ];

    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'campana_id');
    }

    // Método para contar el total de contactos invitados (asociados)
    public function getTotalInvitados()
    {
        $total = '<div class="badge bg-success">'.$this->contactos()->count().'</div>';
        return $total;  
    }
    
}
