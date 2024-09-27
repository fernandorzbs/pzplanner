<?php

namespace App\Imports;

use App\Models\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;


class ContactosImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $campana_id;
    protected $count = 0;

    public function __construct($campana_id)
    {
        $this->campana_id = $campana_id;
    }

    public function model(array $row)
    {
        $nombre     = array_key_exists('nombre', $row) ? ucwords(strtolower($row['nombre'])) : null;
        $apellido   = array_key_exists('apellido', $row) ? ucwords(strtolower($row['apellido'])) : null;
        $email      = array_key_exists('email', $row) ? $row['email'] : null;

        $celular    = array_key_exists('celular', $row) ? $this->estandarizarCelular($row['celular'], $row['pais'] ?? 'PY') : null;

        $genero     = array_key_exists('genero', $row) ? (bool)$row['genero'] : 0;
        $estado     = array_key_exists('estado', $row) ? (bool)$row['estado'] : 1;
        $whatsapp_exist = array_key_exists('whatsapp_exist', $row) ? (bool)$row['whatsapp_exist'] : 0;
        $pais       = array_key_exists('pais', $row) ? $row['pais'] : 'py';
        
        if(array_key_exists('confirmado', $row)){
            switch($row['confirmado']){
                case '' : $confirmado = 1; break;
                case '1' : $confirmado = 2; break;
                case '2' : $confirmado = 3; break;
            }
        }else{
            $confirmado = 1;
        }

        if (empty($celular)) {
            return null; // Ignorar fila si no hay email ni celular
        }

        $contactoExistente = Contacto::where('celular', $celular)->first();

        if ($contactoExistente) {
            return null; // Ignorar si ya existe
        }
        $this->count++; 
        // Si no existe, crear un nuevo registro
        return new Contacto([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'celular' => $celular,
            'genero' => $genero,
            'estado' => $estado,
            'whatsapp_exist' => $whatsapp_exist,
            'pais' => $pais,
            'confirmado' => $confirmado,
            'campana_id' => $this->campana_id,
        ]);
    }
    private function estandarizarCelular($numero, $pais)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            // Parsear el número de teléfono
            $numeroParseado = $phoneUtil->parse($numero, strtoupper($pais));

            // Formatear el número en formato internacional (E.164)
            if ($phoneUtil->isValidNumber($numeroParseado)) {
                return $phoneUtil->format($numeroParseado, PhoneNumberFormat::E164);
            }
        } catch (NumberParseException $e) {
            // Manejar el error si el número no se puede parsear
            return null;
        }

        return null;
    }

    public function getRowCount()
    {
        return $this->count;
    }
}
