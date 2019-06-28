<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\CatStepProc;

class Plataform extends Model
{
    protected $table='cat_plataform';

    protected $primaryKey='testPlataformId';

    protected $fillable=[
      'testPlataformId','testPlataform','available'
    ];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;


    public function catStepProc()
    {
        return $this->belongsTo(CatStepProc::class, 'testPlatformId');
    }
}
