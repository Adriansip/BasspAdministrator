<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AdminSupport extends Model
{
    protected $table='tbl_admin_support';

    protected $primaryKey='id';

    protected $fillable=[
    'fch','tipo','usuario','descripcion','fch_entrega',
    'tecnico','horas','mes'
  ];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;
}
