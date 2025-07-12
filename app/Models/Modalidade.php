<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'descripcion',
        'activo',
    ];

    public function contenidos():array
    {
        $contenidos = [];

        $arr1 = explode("|",$this->contents);

        foreach ($arr1 as $contenido) {
            array_push($contenidos,explode("_",$contenido));

        }

        return $contenidos;
    }
}
