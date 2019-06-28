<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $table='tbl_user_preferences';

    protected $primaryKey='userId';

    protected $fillable=['userId','directory','language','notifications','recording','quality'];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;
}
