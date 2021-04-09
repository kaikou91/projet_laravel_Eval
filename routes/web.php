<?php

use App\Http\Controllers\CritiqueControllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
  $animes = DB::select("SELECT * FROM animes");
  return view('welcome', ["animes" => $animes]);
});

Route::get('/anime/{id}', function ($id) {
  $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
  $critiques = DB::table('reviews')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('animes', 'anime_id', '=', 'animes.id')
            ->select('reviews.*', 'animes.*', 'users.username')
            ->where('animes.id', '=', $id)
            //->orderBy()
            ->get();
  return view('anime', ["critiques" => $critiques, "anime" => $anime]);
});


// modifier la route 
Route::get('/anime/{id}/new_review', function ($id) {  
  if (Auth::user()){
    $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
    return view('new_review', ["anime" => $anime]);
}else{
  return view('login');
}
});

Route::get('/login', function () {
  return view('login');
});

Route::post('/login', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
  ]);
  if (Auth::attempt($validated)) {
    return redirect()->intended('/');
  }
  return back()->withErrors([
    'username' => 'The provided credentials do not match our records.',
  ]);
});

Route::get('/signup', function () {
  return view('signup');
});

Route::post('signup', function (Request $request) {
  $validated = $request->validate([
    "username" => "required",
    "password" => "required",
    "password_confirmation" => "required|same:password"
  ]);
  $user = new User();
  $user->username = $validated["username"];
  $user->password = Hash::make($validated["password"]);
  $user->save();
  Auth::login($user);

  return redirect('/');
});

Route::post('signout', function (Request $request) {
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect('/');
});

//route pour ajouté des critiques
Route::post('anime/{id}',[CritiqueControllers::class,'addCritique']);

//route pour la page top
Route::get('/top', [CritiqueControllers::class,'topAnime']);

//route pour la page watchlist
Route::get('/watchlist', [CritiqueControllers::class,'watchList']);


