<?php

namespace App\Http\Controllers;

use App\Player;
use App\Admin;
use App\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class UsersController extends Controller
{
	public function login()
	{
		if (Auth::guard('admin')->check())
			return redirect('/');
		else if (Auth::guard('player')->check())
			return redirect('/');
		else if (Auth::guard('club')->check())
			return redirect('/');


		return view('users.login');
	}

	public function verifyLogin(Request $request)
	{
		$errorMessages = [
			'email.required' => 'Unesite email!',
			'email.email' => 'Unesite ispravan email!',
			'password.required' => 'Unesite lozinku!',
		];

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		], $errorMessages);

		if ($validator->fails()) {
			return redirect()->action('UsersController@login')
				->withErrors($validator)
				->withInput($request->all());
		}

		$credentials = $request->only('email', 'password');

		$player = Player::where('email', $request->email)->first();
		if ($player == null) {
			$club = Club::where('email', $request->email)->first();

			if ($club == null) {
				$admin = Admin::where('email', $request->email)->first();

				if ($admin == null) {
					$errors = new MessageBag(['login' => ['Pogresan email ili lozinka!']]);
					return redirect()->action('UsersController@login')->withErrors($errors)->withInput();
				}
			} else {
				if ($club->confirmed == false) {
					$errors = new MessageBag(['login' => ['Nalog nije potvrdjen od strane administratora!']]);
					return redirect()->action('UsersController@login')->withErrors($errors)->withInput();
				}
			}
		} else {
			if ($player->confirmed == false) {
				$errors = new MessageBag(['login' => ['Nalog nije potvrdjen od strane administratora!']]);
				return redirect()->action('UsersController@login')->withErrors($errors)->withInput();
			}
		}



		if (Auth::guard('player')->attempt($credentials)) {
			return redirect()->back();
		} else if (Auth::guard('club')->attempt($credentials))
			return redirect()->back();
		else if (Auth::guard('admin')->attempt($credentials))
			return redirect()->back();
		else {
			$errors = new MessageBag(['login' => ['Pogresan email ili lozinka!']]);
			return redirect()->action('UsersController@login')->withErrors($errors)->withInput();
		}
	}

	public function register()
	{
		return view('users.register');
	}

	public function registerPost(Request $request)
	{
		$errorMessages = [
			'required' => 'Unesite :attribute',
			'email.email' => 'Unesite ispravan email!',
			'email.unique' => 'Postoji korisnik sa ovim email-om!',
			'confirmPassword.same' => 'Lozinke se ne poklapaju',
			'birth_date.date' => 'Datum rodjenja mora biti u formi datuma'
		];

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'surname' => 'required',
			'email' => 'required|email|unique:players|unique:clubs|unique:admins',
			'birth_date' => 'required|date',
			'password' => 'required',
			'confirmPassword' => 'required|same:password',
			'gender' => 'required'
		], $errorMessages);


		if ($validator->fails()) {
			return redirect()->action('UsersController@register')
				->withErrors($validator)
				->withInput($request->all());
		}

		if ($request->password == $request->confirmPassword) {
			$player = new Player();
			$player->name = $request->name;
			$player->surname = $request->surname;
			$player->email = $request->email;
			$player->gender = $request->gender;
			$player->birth_date = $request->birth_date;
			$player->password = bcrypt($request->password);
			$player->confirmed = false;

			$player->save();

			return redirect('/');
		}

		return redirect('/korisnici/register');
	}

	public function logout()
	{
		if (Auth::guard('admin')->check())
			Auth::guard('admin')->logout();
		else if (Auth::guard('player')->check())
			Auth::guard('player')->logout();
		else if (Auth::guard('club')->check())
			Auth::guard('club')->logout();

		return redirect('/');
	}
}
