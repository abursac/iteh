<?php

namespace App\Http\Controllers;

use App\Club;
use App\Player;
use App\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class ClubController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:club,admin')->except(['index', 'getClubsPost', 'getPlayers', 'getClub']);
    }

    public function index()
    {
        return view('home');
    }

    public function getClubsPost(Request $data)
    {
        $limit = 10;
        $strana = $data->strana;
        $start = ($strana-1)*$limit;

        $min_datum_filter = $data->min_datum_filter;
        if($min_datum_filter == "") $min_datum_filter = date(1900-1-1);
        $max_datum_filter = $data->max_datum_filter;
        if($max_datum_filter == "") $max_datum_filter = date("Y-m-d");

        $clubs = "";

        $clubs = Club::where('name', 'like', "%".$data->naziv_filter."%" )
        ->where('municipality', 'like', "%".$data->opstina_filter."%")
        ->whereBetween('founded',[$min_datum_filter, $max_datum_filter])
        ->where('confirmed','=',1)
        ->offset($start)
        ->limit($limit)
        ->get();

        $numPages = Club::where('name', 'like', "%".$data->naziv_filter."%" )
        ->where('municipality', 'like', "%".$data->opstina_filter."%")
        ->whereBetween('founded',[$min_datum_filter, $max_datum_filter])->count();

        $num = ceil($numPages/$limit);

        return view('clubs.clubsTable')->with('clubs',$clubs)->with('broj_stranica',$num);
    }

    public function getPlayers($id)
    {
        $limit = 10;

        $veze =  DB::table('club_player')->where('club_id','=',$id)->get();
        $uKlubu = false;
        $players = collect([]);

        foreach($veze as $veza)
        {
            if($veza->left == null) {
                $uKlubu == true;
                $players->push(DB::table('players')->where('id','=',$veza->player_id)->first());    
            }
        }

        $num = ceil($players->count()/$limit);

        return view('clubs.clubPlayerInfo')->with('players',$players)->with('broj_stranica',$num);    
    }

    public function getClub($id)
    {

        $club = Club::where('id', $id)->first();
        if ($club != null) return view('clubs.club')->with('club', $club);
        else return view('home');
    }

    public function addOrEditClubPost(Request $request)
    {
        $club = Club::where('id', "=", $request->id)->first();
        if($club == null)
        {
            Club::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'founded' => $request->founded,
                'municipality' => $request->municipality,
                'address' => $request->address,
                'phone' => $request->phone
            ]);
        }
        else
        {
            Club::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'founded' => $request->founded,
                'municipality' => $request->municipality,
                'address' => $request->address,
                'phone' => $request->phone
            ]);
        }

        return view('home');
    }

    public function editClub($id)
    {
        $club = Club::where('id', $id)->first();
        if ($club != null) return view('clubs.addClub')->with('club', $club);
        else return view('home');
    }

    public function deleteClub($id)
    {
        if (Club::where('id', "=", $id)->first() != null)
            Club::where('id', '=', $id)->delete();

        return view('home');
    }

    public function firePlayer(Request $request)
    {
        //Provera da li je trenutno prelazni rok
        $id_prelazonog_roka = DB::table('deadline_types')->where('tip','=','Rok za napustanje')->first();
        $validan_prelazni_rok = DB::table('deadlines')->where('deadline_type_id','=',$id_prelazonog_roka->id)
                                ->where('start','<',date('Y-m-d'))
                                ->where('end','>',date('Y-m-d'))
                                ->first();
        
        if($validan_prelazni_rok == null)
        {
            $errors = new MessageBag(['error' => ['Otpustanje igraca nije uspesno , trenutno nije prelazni rok!']]);
            $player = DB::table('players')->where('id','=', $request->player_id)->first();
            return view('players.player_info')->with('player',$player)->withErrors($errors);
        }

        $veza = DB::table('club_player')->where('player_id', '=', $request->player_id)
        ->where('club_id', '=', $request->club_id)
        ->update(['left'=>date('Y-m-d')]);
    
        $player = DB::table('players')->where('id','=', $request->player_id)->first();
        return view('home');
    }

    public function sendRequestToPlayer(Request $request)
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
            $player = DB::table('players')->where('id','=', $request->player_id)->first();
            return view('players.player_info')->with('player',$player)->withErrors($errors);
        }

        $datum_isteka = $validan_prelazni_rok->end;


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
                'club' => true,
                'expiry_date' => $datum_isteka
            ]);
            $errors = new MessageBag(['success' => ['Uspesno ste poslali zahtev!']]);
        } else if ($veza != null && $veza->club == true) {
            $errors = new MessageBag(['error' => ['Zahtev je vec poslat!']]);
        } elseif ($check != null && $check->left == null) {
            $errors = new MessageBag(['error' => ['Igrac je vec uclanjen u klub!']]);
        } else {
            $this->acceptPlayer($request);
            $errors = new MessageBag(['success' => ['Imali ste zahtev od ovog igraca, dobili ste novog clana!']]);
        }
        $player = DB::table('players')->where('id','=', $request->player_id)->first();

		return view('players.player_info')->with('player',$player)->withErrors($errors);

    }

    public function acceptPlayer(Request $request)
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

        //Azurira se status obavestenja
        DB::table('player_club_request')
        ->where('player_id','=',$request->player_id)
        ->where('club_id','=',$request->club_id)
        ->update(['club' => true, 'status' => 'accepted']);
        
        $notifications = DB::table('player_club_request')->where('club_id','=',$request->club_id)->where('club','=',false)->get();
        $klub = Club::where('id','=',$request->club_id)->first();
        return view('clubs.clubNotifications')->with('notifications', $notifications)->with('klub',$klub);
    }

    public function declinePlayer(Request $request)
    {
        $veza = DB::table('player_club_request')->where('player_id','=', $request->player_id)->where('club_id', '=', $request->club_id)->first();
        if($veza != null)
        {
            DB::table('player_club_request')
            ->where('player_id','=',$veza->player_id)
            ->where('club_id','=',$veza->club_id)
            ->update(['club' => true,'status' => 'declined']);
        }

        
        $notifications = DB::table('player_club_request')->where('club_id','=',$request->club_id)->where('club','=',false)->get();
        $klub = Club::where('id','=',$request->club_id)->first();
        return view('clubs.clubNotifications')->with('notifications', $notifications)->with('klub',$klub);
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

        $notifications = DB::table('player_club_request')->where('club_id','=',$request->club_id)->where('club','=',false)->get();
        $klub = Club::where('id','=',$request->club_id)->first();
        return view('clubs.clubNotifications')->with('notifications', $notifications)->with('klub',$klub);
    }

    public function getNotifications($id)
    {
        $notifications = DB::table('player_club_request')->where('club_id','=',$id)->where('club','=',false)->get();
        $klub = Club::where('id','=',$id)->first();
        return view('clubs.clubNotifications')->with('notifications', $notifications)->with('klub',$klub);
    }

    public function uploadImage(Request $request)
    {
        Club::where('id','=',$request->id)
        ->update(
            ['image' => file_get_contents($request->image)]
        );

        $club = Club::where('id','=',$request->id)->first();
        return view('clubs.club')->with('club', $club);
    }
}
