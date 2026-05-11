<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotxe extends Model
{
    protected $fillable = ["marca", "model", "cilindrada", "potencia"];
}
