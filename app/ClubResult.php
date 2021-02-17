<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubResult extends Model
{
    public $timestamps = false;

    public function white()
    {
        return $this->belongsTo('App\Club');
    }

    public function black()
    {
        return $this->belongsTo('App\Club');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Tournament');
    }
}
