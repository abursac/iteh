<?php

use App\Http\Controllers\AdminController;
use App\Tournament;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/igrac', 'PlayerController@index');
Route::get('/igrac/{id}', 'PlayerController@getPlayer')->where('id', '[0-9]+');
Route::get('/igrac/dodaj', 'PlayerController@addPlayer');
Route::post('/igrac/dodaj', 'PlayerController@addOrEditPlayerPost');
Route::get('/igrac/izmeni/{id}', 'PlayerController@editPlayer')->where('id', '[0-9]+');
Route::get('/igrac/obrisi/{id}', 'PlayerController@deletePlayer')->where('id', '[0-9]+');
Route::post('/igrac/zahtev_za_klub', 'PlayerController@sendRequestToClub');
Route::get('/igrac/moj_klub/{id}', 'PlayerController@myClub')->where('id', '[0-9]+');
Route::post('/igrac/napusti_klub', 'PlayerController@leaveClub');
Route::post('/igrac', 'PlayerController@getPlayersPost');
Route::get('/igrac/obavestenja/{id}', 'PlayerController@playerNotifications')->where('id', '[0-9]+');
Route::post('/igrac/prihvatiZahtev', 'PlayerController@acceptClub');
Route::post('/igrac/odbijZahtev', 'PlayerController@declineClub');
Route::post('/igrac/ukloniZahtev', 'PlayerController@removeRequest');
Route::post('/igrac/promena_lozinke', 'PlayerController@changePassword');
Route::post('/igrac/slika', 'PlayerController@uploadImage');


Route::get('/turnir', 'TournamentController@index');
Route::get('/turnir/{id}', 'TournamentController@getTournament')->where('id', '[0-9]+');
Route::get('/turnir/dodaj', 'TournamentController@addTournament');
Route::post('/turnir/dodaj', 'TournamentController@addTournamentPost');
Route::get('turnir/{id}/sudije', 'TournamentController@arbiters')->where('id', '[0-9]+');
Route::post('turnir/{id}/dodajSudiju', 'TournamentController@addArbiter')->where('id', '[0-9]+');
Route::post('turnir/{id}/ukloniSudiju', 'TournamentController@removeArbiter')->where('id', '[0-9]+');
Route::get('turnir/{id}/unosRezultata', 'TournamentController@addResults')->where('id', '[0-9]+');
Route::post('turnir/{id}/unosRezultata', 'TournamentController@addResultsPost')->where('id', '[0-9]+');
Route::get('turnir/{id}/rezultati', 'TournamentController@results')->where('id', '[0-9]+');
Route::post('turnir/{idTurnir}/prijavaIgraca/{idIgrac}', 'TournamentController@playerRegistration')->where('idTurnir', '[0-9]+')->where('idIgrac', '[0-9]+');
Route::post('turnir/{idTurnir}/prijavaKluba/{idKlub}', 'TournamentController@clubRegistration')->where('idTurnir', '[0-9]+')->where('idKlub', '[0-9]+');
Route::post('/turnir', 'TournamentController@getTournamentsAjax');

Route::get('/klub', 'ClubController@index');
Route::get('/klub/{id}', 'ClubController@getClub')->where('id', '[0-9]+');
Route::get('/klub/obrisi/{id}', 'ClubController@deleteClub')->where('id', '[0-9]+');
Route::get('/klub/izmeni/{id}', 'ClubController@editClub')->where('id', '[0-9]+');
Route::get('/klub/igraci/{id}', 'ClubController@getPlayers')->where('id', '[0-9]+');
Route::post('/klub/dajOtkazIgracu', 'ClubController@firePlayer')->where('id', '[0-9]+');
Route::get('/klub/obavestenja/{id}', 'ClubController@getNotifications')->where('id', '[0-9]+');
Route::post('/klub/dodaj', 'ClubController@addOrEditClubPost');
Route::post('/klub', 'ClubController@getClubsPost');
Route::post('/klub/prihvatiZahtev', 'ClubController@acceptPlayer');
Route::post('/klub/odbijZahtev', 'ClubController@declinePlayer');
Route::post('/klub/ukloniZahtev', 'ClubController@removeRequest');
Route::post('/klub/posaljiZahtevIgracu', 'ClubController@sendRequestToPlayer');
Route::post('/klub/slika' , 'ClubController@uploadImage');

Route::get('/sudija', 'PlayerController@referees'); // prikazuje sve sudije

Route::get('/igrac/sudija/{id}', 'PlayerController@promote')->where('id', '[0-9]+');
Route::post('/igrac/sudija/{id}', 'PlayerController@promotePost')->where('id', '[0-9]+'); // dodeljuje igracu status sudije
Route::get('/rokovi', 'AdminController@deadlines'); // prikazuje trenutne rokove
Route::get('/dodajRok', 'AdminController@addDeadline');
Route::post('/dodajRok', 'AdminController@addDeadlinePost'); // dodaje rok
Route::get('/korisnici', 'AdminController@getPendingRegs'); //dohvata korisnike koji cekaju da im se odobri registacija
Route::get('/korisnici/{id}', 'AdminController@pendingRegs')->where('id', '[0-9]+');
Route::post('/korisnici/{id}', 'AdminController@pendingRegsPost')->where('id', '[0-9]+');
Route::get('/klubovi', 'AdminController@getPendingRegsClubs');
Route::get('/klubovi/{id}', 'AdminController@pendingRegsClubs')->where('id', '[0-9]+');
Route::post('/klubovi/{id}', 'AdminController@pendingRegsClubsPost')->where('id', '[0-9]+');
Route::get('/adminProfil', 'AdminController@editProfile'); //pregled i edit adminovog profila
Route::post('/promenaEmaila', 'AdminController@editEmail');
Route::post('/promenaLozinke', 'AdminController@changePassword');
Route::get('/admin', 'AdminController@index');

Route::get('/korisnici/login', 'UsersController@login')->name("login");
Route::post('/korisnici/login', 'UsersController@verifyLogin');
Route::get('/korisnici/logout', 'UsersController@logout');
Route::get('/korisnici/registracija', 'UsersController@register');
Route::post('/korisnici/registracija', 'UsersController@registerPost');
