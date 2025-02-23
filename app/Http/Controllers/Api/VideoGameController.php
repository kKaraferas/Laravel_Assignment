<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;

class VideoGameController extends Controller
{
    //Constructor to ensure that only authenticated users can access the methods
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    //View all

    public function index(Request $request){

        $query = VideoGame::query();

        $query->where('user_id', auth()->id());

        if($request->has('genre')){
            $games = $query->where('genre', $request->input('genre'))->get();

            if($games->isEmpty()){
                return response()->json(['message' => 'There is not a game with this genre.'], 404);
            }
        }

        if($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])){
            $query->orderBy('release_date', $request->input('sort'));
        }else{
            $query->orderBy('id', 'asc');
        }

        return response()->json($query->get(), 200);
        // return response()->json(VideoGame::all(),200);
    }

    //View one

    public function show($id){
        $videoGame = VideoGame::find($id);

        if($videoGame){
            return response()->json($videoGame, 200);
        }
        return response()->json(['message' => 'Video Game not found'], 404);
    }

    //Add a new Game

    public function gameCreation(Request $request){
        try{
            $validated = $request->validate([
                'title'=>'required|string|max:50',
                'description'=> 'required',
                'release_date' => 'required|date',
                'genre' => 'required|string|max:20'
            ]);

            $validated['user_id'] = auth()->id();

            $videoGame = VideoGame::create($validated);

            return response()->json($videoGame, 201);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()],422);
        }
    }

    //Edit a Game

    public function gameUpdate(Request $request, $id){
        $videoGame = VideoGame::find($id);

        if(!$videoGame){
            return response()->json(['message' => 'Video Game not found'], 404);
        }

        try{
            $validated = $request->validate([
            'title'=>'required|string|max:50',
            'description'=> 'required',
            'release_date' => 'required|date',
            'genre' => 'required|string|max:20' 
            ]);

            $videoGame->update($validated);
            return response()->json($videoGame, 200);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }

        
    }
    
    // Delete a Game

    public function gameDeletion($id){
        $videoGame = VideoGame::find($id);

        if($videoGame){
            $videoGame->delete();
            return response()->json(['message' => 'Game deleted successfully'], 200);
        }

        return response()->json(['message' => 'Video game Not found'], 404);
    }
}
