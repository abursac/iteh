<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubResult;
use App\Player;
use App\Result;
use Illuminate\Http\Request;
use App\Tournament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class PlayerPoints
{
    public $player;
    public $points;
}

class TournamentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:player,club,admin')->except(['index', 'getTournament', 'getTournamentsAjax']);
    }

    public function index()
    {
        return view('tournaments.tournaments', [
            'tournaments' => Tournament::orderByDesc('start_date')->orderByDesc('time')->get()
        ]);
    }

    public function getTournament($id)
    {
        $tournament = Tournament::where('id', $id)->first();

        if ($tournament == null)
            return redirect('/');

        $type = 'App\Result';
        if ($tournament->type == 'club')
            $type = 'App\ClubResult';

        $rounds = $type::where('tournament_id', $tournament->id)->distinct('round')->count();

        $table = array();

        foreach ($tournament->participants as $participant) {
            $player = new PlayerPoints();
            $player->player = $participant;
            $player->points = $participant->getTournamentPoints($id);
            $table[] = $player;
        }


        usort($table, function ($first, $second) {
            return $first->points < $second->points;
        });


        return view('tournaments.tournament', [
            'tournament' => $tournament,
            'rounds' => $rounds,
            'table' => $table,
            'type' => $type
        ]);
    }

    public function addTournament()
    {
        return view('tournaments.addTournament');
    }

    public function addTournamentPost(Request $request)
    {
        $errorMessages = [
            'required' => ':attribute se mora popuniti',
            'email.email' => 'Unesite ispravan email!',
            'start_date.before' => 'Datum pocetka mora biti pre datum zavrsetka'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date',
            'time' => 'required',
            'rounds' => 'required|min:1',
            'phone' => 'required',
            'email' => 'required|email',
            'place' => 'required',
            'type' => 'required',
        ], $errorMessages);

        if ($validator->fails()) {
            return redirect()->action('TournamentController@addTournament')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        Tournament::insert([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'time' => $request->time,
            'rounds' => $request->rounds,
            'phone' => $request->phone,
            'email' => $request->email,
            'place' => $request->place,
            'type' => $request->type,
            'playersPerClub' => $request->playersPerClub
        ]);

        return redirect()->action('TournamentController@index');
    }

    public function playerRegistration(Request $request)
    {
        $player = Player::where('id', $request->idIgrac)->get();

        $tournament = Tournament::where('id', $request->idTurnir)->first();

        $tournament->participants()->toggle($player);

        return redirect()->back();
    }

    public function clubRegistration(Request $request)
    {
        $club = Club::where('id', $request->idKlub)->first();

        $tournament = Tournament::where('id', $request->idTurnir)->first();


        $tournament->participants()->toggle($club);

        return redirect()->back();
    }

    public function arbiters($id)
    {
        $tournament = Tournament::where('id', $id)->first();

        if ($tournament == null)
            return redirect('/');

        $arbiters = Player::whereNotNull('arbiter_rank_id')->get();
        return view('tournaments.arbiters', [
            'tournament' => $tournament,
            'arbiters' => $arbiters
        ]);
    }

    public function addArbiter(Request $request)
    {
        $tournament = Tournament::where('id', $request->id)->first();

        if ($tournament == null)
            return redirect('/turnir/' . $request->id . '/sudije');

        $tournament->arbiters()->syncWithoutDetaching($request->arbiter_id);
        return redirect('/turnir/' . $request->id . '/sudije');
    }

    public function removeArbiter(Request $request)
    {
        $tournament = Tournament::where('id', $request->id)->first();
        if ($tournament == null)
            return redirect('/');

        $tournament->arbiters()->detach($request->arbiter_id);
        return redirect('/turnir/' . $request->id . '/sudije');
    }

    public function addResults($id)
    {
        $tournament = Tournament::where('id', $id)->first();

        if ($tournament == null)
            return redirect('/');

        return view('tournaments.addResults', [
            'tournament' => $tournament
        ]);
    }

    public function results(Request $request)
    {
        $tournament = Tournament::where('id', $request->id)->first();

        if ($tournament == null)
            return redirect('/');

        $results = collect();

        if ($tournament->type == 'player')
            $results = Result::where('tournament_id', $request->id)->where('round', $request->round)->orderBy('table')->get();
        else
            $results = ClubResult::where('tournament_id', $request->id)->where('round', $request->round)->orderBy('table')->get();

        return view('tournaments.resultsPartial', [
            'results' => $results,
            'maxTables' => $tournament->participants()->count() / 2,
            'tournament' => $tournament
        ]);
    }

    public function addResultsPost(Request $request)
    {
        $tournament = Tournament::where('id', $request->id)->first();

        if ($tournament == null)
            return redirect('/');

        if ($tournament->type == "player") {
            for ($i = 0; $i < sizeof($request->white); $i++) {
                if ($request->white[$i] == 0 || $request->black[$i] == 0)
                    continue;

                $res = Result::where([
                    ['tournament_id', '=', $request->id],
                    ['round', '=', $request->round],
                    ['table', '=', $request->table[$i]]
                ])->exists();


                if ($res == true) {
                    Result::where([
                        ['tournament_id', '=', $request->id],
                        ['round', '=', $request->round],
                        ['table', '=', $request->table[$i]]
                    ])->update([
                        'white_id' => $request->white[$i],
                        'black_id' => $request->black[$i],
                        'white_result' => $request->result[$i] / 2,
                        'black_result' => 1 - $request->result[$i] / 2,
                        'arbiter_id' => Auth::user()->id
                    ]);
                } else {
                    Result::insert([
                        'white_id' => $request->white[$i],
                        'black_id' => $request->black[$i],
                        'tournament_id' => $request->id,
                        'white_result' => $request->result[$i] / 2,
                        'black_result' => 1 - $request->result[$i] / 2,
                        'round' => $request->round,
                        'table' => $request->table[$i],
                        'arbiter_id' => Auth::user()->id
                    ]);
                }
            }
        } else {
            for ($i = 0; $i < sizeof($request->white); $i++) {
                if ($request->white[$i] == 0 || $request->black[$i] == 0)
                    continue;

                $res = ClubResult::where([
                    ['tournament_id', '=', $request->id],
                    ['round', '=', $request->round],
                    ['table', '=', $request->table[$i]]
                ])->exists();


                if ($res == true) {
                    ClubResult::where([
                        ['tournament_id', '=', $request->id],
                        ['round', '=', $request->round],
                        ['table', '=', $request->table[$i]]
                    ])->update([
                        'white_id' => $request->white[$i],
                        'black_id' => $request->black[$i],
                        'white_result' => $request->result[$i],
                        'black_result' => $tournament->playersPerClub - $request->result[$i],
                        'arbiter_id' => Auth::user()->id
                    ]);
                } else {
                    ClubResult::insert([
                        'white_id' => $request->white[$i],
                        'black_id' => $request->black[$i],
                        'tournament_id' => $request->id,
                        'white_result' => $request->result[$i],
                        'black_result' => $tournament->playersPerClub - $request->result[$i],
                        'round' => $request->round,
                        'table' => $request->table[$i],
                        'arbiter_id' => Auth::user()->id
                    ]);
                }
            }
        }


        return redirect('/turnir/' . $request->id);
    }

    public function getTournamentsAjax(Request $data)
    {
        $limit = 10;
        $page = $data->page;
        $start = ($page - 1) * $limit;
        $query = Tournament::query();

        $query = $query->where('name', 'like', "%" . $data->name . "%")->where('place', 'like', "%" . $data->place . "%");

        if ($data->rounds != "")
            $query = $query->where('rounds', '=', $data->rounds);

        if ($data->start_date != "")
            $query = $query->where('start_date', '>=', $data->start_date);

        if ($data->end_date != "")
            $query = $query->where('end_date', '<=', $data->end_date);

        $number_of_rows = $query->count();
        $tournaments = $query->offset($start)->limit($limit)->get();

        $number_of_pages = ceil($number_of_rows / $limit);
        return view('tournaments.tournaments_table')->with('tournaments', $tournaments)->with('number_of_pages', $number_of_pages);
    }
}
