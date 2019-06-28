<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Platform;

class CatStepProc extends Model
{
    protected $table='cat_step_proc';

    protected $primaryKey='procId';

    protected $fillable=[
        'procId','testPlataformId','stepProcName','available','hint',
        'stepFunctionName'
    ];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;

    public function plataform()
    {
        return $this->hasOne(Plataform::class, 'testPlataformId', 'testPlataformId');
    }
}
