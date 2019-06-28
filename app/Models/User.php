<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table ="tbl_users";
    public $primaryKey='userId';

    public $fillable=['userId','userName','userLastName',
    'userMotherLastName','userNick','userPwd','userRolId',
    'userLastAccessIP','userUniqueID','userLastAccess','userEmail',
    'userUntil','userToken','userPhone'
    ];

    protected $hidden = ['userToken'];

    /*Desactivar etiquetas de created_at y updated_at*/
    public $timestamps=false;
}
