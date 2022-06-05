<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Superviviente extends Model
{
    //
    protected $fillable = ['nombre', 'edad', 'genero', 'latitud', 'longitud', 'infectado','reportado'];
    
    

}
