<?php
namespace app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Critique;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class CritiqueControllers
    {
        
        public function addCritique(Request $request)
            {                                 
                //validation des données               
                $validatedData = $request->validate([        
                    "notes" => "required",
                    "idUser" => "required",
                    "idAnime" => "required",
                    "user_message" => "required"
                    ]);

                // modéle                                
                $critique = new Critique();

                //on ajoute la valeur dans la column titre dans la BDD                            
                $critique->comment = $validatedData["user_message"];
                $critique->user_id = $validatedData["idUser"];
                $critique->anime_id = $validatedData["idAnime"];
                $critique->rating = $validatedData["notes"];        
                $critique->save();
                
                //vue                                                               
                return redirect('/anime/'.$critique->anime_id);
                               
            }
    //requete pour recupérer le top des animes

        public function topAnime()
            {

                $topAnimes = DB::table('animes')
                    ->join('reviews', 'animes.id', '=', 'anime_id')
                    ->select(
                        'animes.title',
                        'animes.cover',
                        DB::raw('AVG(reviews.rating) as moyenne')                        
                    )
                    ->groupBy('animes.title', 'animes.cover')
                    ->orderBy('moyenne', 'DESC')                    
                    ->get();

                return view('top_anime', ["topAnimes" => $topAnimes]);
            } 

    //requete pour la page watchlist
        public function watchList(Request $request)
            {
                if (Auth::user()){
                    $id = $request->session()->get('user_id');
                    $addToWatchList = DB::table('animes')
                        
                        ->join('watchlists', 'anime_id', '=', 'animes.id')
                        ->select('animes.*')
                        ->where('watchlists.user_id', '=', $id)
                        ->get();
                        return view('watchlist', ["addToWatchList" => $addToWatchList]);
                    
                    return view('watchlist');
                }else{
                  return view('login');
                }
            }

    // requete pour ajouté une anime a la watchlist
        public function add_to_watch_list(Request $request)
            {              
                if (Auth::user()){

                    //validation des données               
                $validatedData = $request->validate([          
                    "idUser" => "required",
                    "idAnime" => "required",
                    ]);

                    // modéle                                
                $watchlist = new Watchlist();

                //on ajoute la valeur dans la column titre dans la BDD                            
                
                $watchlist->user_id = $validatedData["idUser"];
                $watchlist->anime_id = $validatedData["idAnime"];
                $watchlist->save();
                    
                    return view('watchlist');
                }else{
                  return view('login');
                }
            }
    }