<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='tbl_notificaciones';

    protected $primaryKey='id';

    protected $fillable=[
      'fecha','titulo','descripcion'
    ];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;
}
