<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intercambio extends Model
{
    //
    protected $fillable = ['cantidad', 'superviviente_envia_id', 'superviviente_recibe_id','item_id', 'transaccion_id'];
}
