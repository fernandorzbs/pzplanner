<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Contacto extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'contactos';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'celular',
        'genero',
        'estado',
        'whatsapp_exist',
        'pais',
        'confirmado',
        'campana_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatarcontacto')
            ->fit(Fit::Crop, 300, 300)
            ->nonQueued();
    }

    public function getAvatar()
    {
        $defaultAvatar = 'admins/img/default.svg';
        if ($this->avatarcontacto) {
            return $this->avatarcontacto;
        }
        if ($this->hasMedia('profile_image')) {
            return $this->getFirstMediaUrl('profile_image', 'avatarcontacto');

        }
        return $defaultAvatar;
    }
    public function getConfirmacion()
    {
        switch($this->confirmado){
            case 1 : $confirmado = '<div class="badge rounded-pill border border-secondary text-secondary">Sin confirmar</div>'; break;
            case 2 : $confirmado = '<div class="badge rounded-pill border border-warning text-warning">Confirmado</div>'; break;
            case 3 : $confirmado = '<div class="badge rounded-pill border border-success text-success">Con pareja</div>'; break;
        }
        return $confirmado;
    }
    public function getFormateado()
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numeroParseado = $phoneUtil->parse($this->celular, null);
            return $phoneUtil->format($numeroParseado, PhoneNumberFormat::NATIONAL);
        } catch (NumberParseException $e) {
            return $this->celular;
        }
        return "$this->celular";
    }
    //getEventos
    public function getEventos()
    {
        return $this->hasMany(Campana::class, 'contacto_id');
    }
}
