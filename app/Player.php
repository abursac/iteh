<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Player extends User
{
	use Notifiable;

	protected $fillable = [
		'name', 'surname', 'gender', 'email', 'password', 'rating', 'birth_date'
	];

	protected $hidden = [
		'password', 'remember_token',
	];


	public $timestamps = false;

	public function tournaments()
	{
		return $this->belongsToMany('App\Tournament');
	}

	public function club()
	{
		return $this->belongsToMany('App\Club');
	}

	public function isArbiter()
	{
		if ($this->belongsTo('App\ArbiterRank', 'arbiter_rank_id')->first() != null)
			return true;

		return false;
	}

	public function getArbiterRank()
	{
		if ($this->isArbiter()) {
			return $this->belongsTo('App\ArbiterRank', 'arbiter_rank_id')->first()->name;
		}

		return null;
	}

	public function getPlayerRank()
	{
		$rank = $this->belongsTo('App\PlayerRank', 'player_rank_id')->first();
		if ($rank == null)
			return "";

		return $rank->name;
	}

	public function getTournamentPoints($id)
	{
		$results = Result::where('tournament_id', $id)->get();

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
