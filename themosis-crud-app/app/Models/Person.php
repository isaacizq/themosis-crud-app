<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'rut',
        'fecha_nacimiento'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
    
    /**
     * Valida un RUT chileno
     * 
     * @param string $rut
     * @return bool
     */
    public static function validarRut($rut)
    {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        
        foreach(array_reverse(str_split($numero)) as $v)
        {
            if($i==8) $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        
        $dvr = 11 - ($suma % 11);
        
        if($dvr == 11) $dvr = 0;
        if($dvr == 10) $dvr = 'K';
        
        return strtoupper($dv) == strtoupper($dvr);
    }
}