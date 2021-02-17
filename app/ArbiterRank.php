<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArbiterRank extends Model
{
    public function arbiters()
    {
        return $this->hasMany('App\Player');
    }
}
