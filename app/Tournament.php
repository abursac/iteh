<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tournament extends Model
{
	public function participants()
	{
		if ($this->type == 'club')
			return $this->belongsToMany('App\Club');
		else if ($this->type == 'player')
			return $this->belongsToMany('App\Player');

		else
			return null;
	}

	public function isPlayerParticipating($id)
	{
		if ($this->participants()->where('id', Auth::guard('player')->user()->id)->first() != null)
			return true;

		return false;
	}

	public function isClubParticipating($id)
	{
		if ($this->participants()->where('id', Auth::guard('club')->user()->id)->first() != null)
			return true;

		return false;
	}

	public function arbiters()
	{
		return $this->belongsToMany('App\Player', 'arbiter_tournament', 'tournament_id', 'arbiter_id');
	}
}
