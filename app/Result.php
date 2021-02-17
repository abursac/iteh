<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public $timestamps = false;

    public function white()
    {
        return $this->belongsTo('App\Player');
    }

    public function black()
    {
        return $this->belongsTo('App\Player');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}
