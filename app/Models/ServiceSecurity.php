<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceSecurity extends Model
{
    protected $table='tbl_service_security';

    protected $primaryKey='licenseId';

    protected $fillable=[
      'service_id','userId','licenseId','creationDate','expirationDate',
      'licenseKey','executor_id','executor_uid'
    ];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;
}
