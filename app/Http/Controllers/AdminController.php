<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Club;
use Illuminate\Http\Request;
use App\Deadline;
use App\DeadlineType;
use App\Player;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class AdminController extends Controller {
    public function __construct(){
        $this->middleware('auth:admin')->except(['index', 'deadlines']);
    }

    public function index(){
        return view('home');
    }

    public function addDeadline(){
        return view('admin.addDeadline', ['deadlineTypes'=>DeadlineType::all()]);
    }

    public function addDeadlinePost(Request $request){
        if ($request->start < $request->end){
        Deadline::insert([
            'start' => $request->start,
            'end' => $request->end,
            'deadline_type_id' => $request->tip
        ]);
        return redirect()->action('AdminController@deadlines');
        }
        else return redirect()->action('AdminController@addDeadline');
    }

    public function deadlines(){
        $deadlines = Deadline::all();
        if ($deadlines->count()==0) return redirect()->action('AdminController@index');
        return view('admin.deadlines', [
            'deadlines' => $deadlines
        ]);
    }

    public function getPendingRegs(){
        $users = Player::all();
        return view('admin.users', [
            'users' => $users
        ]);
    }

    public function getPendingRegsClubs(){
        $clubs = Club::all();
        return view('admin.clubs', [
            'clubs' => $clubs
        ]);
    }

    public function pendingRegs($id){
        $user = Player::where('id', $id)->first();
        return view('admin.reg', [
            'user' => $user
        ]);
    }

    public function pendingRegsClubs($id){
        $club = Club::where('id', $id)->first();
        return view('admin.regClubs', [
            'club' => $club
        ]);
    }

    public function pendingRegsPost(Request $request){
        Player::where('id', $request->id)->update([
            'rating' => $request->rating,
            'confirmed' => $request->confirm
        ]);

        Player::where('confirmed', 2)->delete();
        
        return redirect()->action('AdminController@getPendingRegs');
    }

    public function pendingRegsClubsPost(Request $request){
        Club::where('id', $request->id)->update([
            'confirmed' => $request->confirm
        ]);

        Club::where('confirmed', 2)->delete();

        return redirect()->action('AdminController@getPendingRegsClubs');
    }

    public function editProfile(){
        $user = Auth::guard('admin')->user();
        $admin = Admin::where('id', $user->id)->first();

        return view('admin.profile', [
            'admin' => $admin
        ]);
    }

    public function editEmail(Request $request){
        Admin::where('id', $request->a_id)->update([
            'email' => $request->email
        ]);

        return redirect()->action('AdminController@editProfile');
    }

    public function changePassword(Request $request){
        $admin_info = Admin::where('id','=',$request->admin_id)->first();
        if(!Hash::check($request->old_pass,$admin_info->password) || ($request->new_pass != $request->new_pass_2))
        {
            $errors = new MessageBag(['error' => ['Nesto od podatak nije ispravno, pokusajte ponovo!']]);
            return view('admin.profile')->with('admin',$admin_info)->withErrors($errors);
        } 

        Admin::where('id','=',$request->admin_id)->update(['password' => bcrypt($request->new_pass)]);

        $errors = new MessageBag(['success' => ['Uspesno izmenjena lozinka!']]);
        return view('admin.profile')->with('admin',$admin_info)->withErrors($errors);
    }
}