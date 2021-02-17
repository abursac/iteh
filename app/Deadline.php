<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    public function deadlineTypes(){
        return $this->belongsTo('App\DeadlineType', 'deadline_type_id');
    }
}
