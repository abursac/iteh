<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Club extends User
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'founded', 'municipality', 'address', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    public function tournaments()
    {
        return $this->belongsToMany('App\Tournament');
    }

    public function players()
    {
        return $this->belongsToMany('App\Player');
    }

    public function playerCount()
    {
        $playerCnt = Club::withCount('players')->get();
        return $playerCnt->players_count;
    }

    public function getTournamentPoints($id)
    {
        if (Tournament::where('id', $id)->first()->type == 'player')
            $results = Result::where('tournament_id', $id)->get();
        else
            $results = ClubResult::where('tournament_id', $id)->get();

        $points = 0;
        foreach ($results as $result) {
            if ($result->white->id == $this->id) {
                $points += $result->white_result;
            } else if ($result->black->id == $this->id) {
                $points += $result->black_result;
            }
        }

        return $points;
    }
}
