<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeadlineType extends Model
{
    public function deadlines(){
        return $this->hasMany('App\Deadline');
    }
}
