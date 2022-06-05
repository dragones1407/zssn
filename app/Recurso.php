<?php

namespace App;

use App\Item;
use App\Superviviente;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    //
    protected $fillable = ['cantidad', 'superviviente_id','item_id'];

    public function superviviente() {
        return $this->hasOne(Superviviente::class,'id','superviviente_id');
    }

    public function item() {
        return $this->hasOne(Item::class,'id','item_id');
    }
}
