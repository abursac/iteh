<?php

namespace App\Http\Controllers;

use App\ArbiterRank;
use App\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:player,admin,club')->except(['index', 'getPlayersPost', 'getPlayer']);
    }

    public function index()
    {
        return view('home');
    }

    public function getPlayersPost(Request $data)
    {
        $limit = 10;
        $page = $data->page;
        $start = ($page-1)*$limit;

        $query = Player::query();
        $query = $query->where('confirmed', '=', 1)->where('name','like',"%".$data->name."%");

        if($data->gender != 'Svi')
            $query = $query->where('gender','=',$data->gender);

        if($data->min_rating != "")
            $query = $query->where('rating','>=',$data->min_rating);
        
        if($data->max_rating != "")
            $query = $query->where('rating','<=',$data->max_rating);
        
        $number_of_rows = $query->count();
        $number_of_pages = ceil($number_of_rows/$limit);
        $players = $query->offset($start)->limit($limit)->get();

        return view('players.players_table')->with('players',$players)->with('number_of_pages',$number_of_pages);
    }

    public function getPlayer($id)
    {
        $player = Player::where('id', $id)->first();

        if($player != null)
            return view('players.player_info')->with('player',$player);
        else
        return view('home');
    }
    
    public function addPlayer()
    {
        return view('players.addPlayer');
    }

    public function addOrEditPlayerPost(Request $request)
    {
        $player = Player::where('id',"=", $request->id)->first();
        if($player == null)
        {
            Player::insert([
                'name' => $request->name,
                'surname' => $request->surname,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => $request->password,
                'birth_date' => $request->birth_date,
                'rating' => $request->rating
            ]);
        }
        else
        {
            if($request->rating !=null)
            {
                Player::where('id', $request->id)->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'birth_date' => $request->birth_date,
                    'rating' => $request->rating
                ]);
            }
            else
            {
                Player::where('id', $request->id)->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'birth_date' => $request->birth_date,
                ]);
            }
        }

        return view('home');
    }

    public function editPlayer($id)
    {
        $player = Player::where('id', $id)->first();
        return view('players.addPlayer')->with('player', $player);
    }

    public function deletePlayer($id)
    {
        if(Player::where('id',"=", $id)->first() != null)
            Player::where('id','=',$id)->delete();

        return view('home');
    }

    public function sendRequestToClub(Request $request)
    {  
        //Provera da li je trenutno prelazni rok
        $id_prelazonog_roka = DB::table('deadline_types')->where('tip','=','Rok za uclanjivanje')->first();
        $validan_prelazni_rok = DB::table('deadlines')->where('deadline_type_id','=',$id_prelazonog_roka->id)
                                ->where('start','<',date('Y-m-d'))
                                ->where('end','>',date('Y-m-d'))
                                ->first();
        
        if($validan_prelazni_rok == null)
        {
            $errors = new MessageBag(['error' => ['Zahtev nije poslat zato sto trenutno nije prelazni rok!']]);
            $club = DB::table('clubs')->where('id','=', $request->club_id)->first();
            return view('clubs.club')->with('club',$club)->withErrors($errors);
        }

        $datum_isteka = $validan_prelazni_rok->end;
        //
        $veza = DB::table('player_club_request')
        ->where('player_id','=', $request->player_id)
        ->where('club_id', '=', $request->club_id)
        ->where('status','=','sent')
        ->first(); 

        $errors = null;

        $check = DB::table('club_player')
        ->where('player_id','=', $request->player_id)
        ->whereNull('left')->first(); 

        if ($veza == null && $check == null) 
        {
            DB::table('player_club_request')->insert([
                'player_id' => $request->player_id,
                'club_id' => $request->club_id,
                'club' => false,
                'expiry_date' => $datum_isteka
            ]);
            $errors = new MessageBag(['success' => ['Uspesno ste poslali zahtev!']]);
        } elseif ($veza != null && $veza->club == false) {
            $errors = new MessageBag(['error' => ['Zahtev je vec poslat!']]);
        } elseif ($check != null) {
            $errors = new MessageBag(['error' => ['Vec ste uclanjeni u klub!']]);
        } else {
            $this->acceptClub($request);
            $errors = new MessageBag(['success' => ['Imali ste zahtev od ovog kluba, uclanjeni ste!']]);
        }
        $club = DB::table('clubs')->where('id','=', $request->club_id)->first();
		return view('clubs.club')->with('club',$club)->withErrors($errors);
    }

    public function myClub($id)
    {
        $u_klubu = false;
        $veze =  DB::table('club_player')->where('player_id','=',$id)->get();
        foreach($veze as $veza)
        {
            if($veza->left == null)
                $u_klubu = true;
        }
        if($u_klubu == false)
            return view('players.player_club_info');       
        else
        {
            $klub = DB::table('clubs')->where('id','=',$veza->club_id)->first();
            return redirect('/klub/'.$klub->id);
        }
    }

    public function referees()
    {
        $players = Player::all();
        return view('admin.referees', ['players' => $players]);
    }

    public function promote($id)
    {
        $player = Player::where('id', $id)->first();
        $arbiterRanks = ArbiterRank::all();
        return view('admin.promote', [
            'player' => $player,
            'arbiterRanks' => $arbiterRanks
        ]);
    }

    public function promotePost(Request $request)
    {
        Player::where('id', $request->id)->update([
            'arbiter_rank_id' => $request->rang
        ]);

        return redirect()->action('PlayerController@referees');
    }

    public function playerNotifications($id)
    {
        $notifications = DB::table('player_club_request')->where('player_id','=',$id)->where('club','=',true)->get();
        return view('players.player_notification')->with('obavestenja',$notifications);
    }

    public function acceptClub(Request $request)
    {
        //Provera da li je igrac slucajno vec u klubu
        $u_klubu = false;
        $veze = DB::table('club_player')->where('player_id','=',$request->player_id)->get();
        foreach($veze as $veza)
        {
            if($veza->left==null)
            {
                $u_klubu = true;
                 break;
            }
        }

        //Ako nije uclanjuje se
        if($u_klubu == false)
        {
            DB::table('club_player')->insert([
                'player_id' => $request->player_id,
                'club_id' => $request->club_id,
                'joined' => date('Y-m-d')
            ]);
        }

        //Azurira se da je prihvacen zahtev
        DB::table('player_club_request')
        ->where('player_id','=',$request->player_id)
        ->where('club_id','=',$request->club_id)
        ->update(['status' => 'accepted','club' => false]);

        $notifications = DB::table('player_club_request')->where('player_id', '=', $request->player_id)->where('club','=',true)->get();
        return view('players.player_notification')->with('obavestenja',$notifications);
    }

    public function leaveClub(Request $request)
    {
        //Provera da li je trenutno prelazni rok
        $id_prelazonog_roka = DB::table('deadline_types')->where('tip','=','Rok za napustanje')->first();
        $validan_prelazni_rok = DB::table('deadlines')->where('deadline_type_id','=',$id_prelazonog_roka->id)
                                ->where('start','<',date('Y-m-d'))
                                ->where('end','>',date('Y-m-d'))
                                ->first();
        
        if($validan_prelazni_rok == null)
        {
            $errors = new MessageBag(['error' => ['Napustanje kluba nije uspesno zato sto trenutno nije prelazni rok!']]);
            $club = DB::table('clubs')->where('id','=', $request->club_id)->first();
            return view('clubs.club')->with('club',$club)->withErrors($errors);
        }

        $veza = DB::table('club_player')->where('player_id', '=', $request->player_id)
        ->where('club_id', '=', $request->club_id)
        ->update(['left'=>date('Y-m-d')]);
    
        $club = DB::table('clubs')->where('id', '=', $request->club_id)->first();
        return view('clubs.club')->with('club', $club);
    }

    public function declineClub(Request $request)
    {
        $veza = DB::table('player_club_request')->where('player_id','=', $request->player_id)->where('club_id', '=', $request->club_id)->first();
        if($veza != null)
        {
            DB::table('player_club_request')
            ->where('player_id','=',$veza->player_id)
            ->where('club_id','=',$veza->club_id)
            ->update(['club' => false,'status' => 'declined']);
        }

        $notifications = DB::table('player_club_request')->where('player_id','=',$request->player_id)->where('club','=',true)->get();
        return view('players.player_notification')->with('obavestenja',$notifications);
    }

    public function removeRequest(Request $request)
    {
        $veza = DB::table('player_club_request')->where('player_id','=', $request->player_id)->where('club_id', '=', $request->club_id)
        ->where('status','<>','sent')
        ->first();
        if($veza != null)
        {
            DB::table('player_club_request')
            ->where('player_id','=', $veza->player_id)
            ->where('club_id', '=', $veza->club_id)
            ->where('status','=',$veza->status)
            ->delete();
        }

        $notifications = DB::table('player_club_request')->where('player_id','=',$request->player_id)->where('club','=',true)->get();
        return view('players.player_notification')->with('obavestenja',$notifications);
    }
    
    public function changePassword(Request $request)
    {
        $player_info = Player::where('id','=',$request->player_id)->first();
        if(!Hash::check($request->old_pass,$player_info->password) || ($request->new_pass != $request->new_pass_2))
        {
            $errors = new MessageBag(['error' => ['Nesto od podatak nije ispravno, pokusajte ponovo!']]);
            return view('players.player_info')->with('player',$player_info)->withErrors($errors);
        } 

        Player::where('id','=',$request->player_id)->update(['password' => bcrypt($request->new_pass)]);

        $errors = new MessageBag(['success' => ['Uspesno izmenjena lozinka!']]);
        return view('players.player_info')->with('player',$player_info)->withErrors($errors);
    }

    public function uploadImage(Request $request)
    {
        Player::where('id','=',$request->id)
        ->update(
            ['image' => file_get_contents($request->image)]
        );

        $player = Player::where('id','=',$request->id)->first();
        return view('players.player_info')->with('player',$player);
    }
}

