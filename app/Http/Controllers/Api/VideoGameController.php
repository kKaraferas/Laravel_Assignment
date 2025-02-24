<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;

class VideoGameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request){

        $query = VideoGame::query();

        if(auth()->user()->role !== 'admin'){
            $query->where('user_id', auth()->id());
        }

        

        if($request->has('genre')){
            $games = $query->where('genre', $request->input('genre'))->get();
        }

        if($request->has('sort') && in_array($request->input('sort'), ['asc', 'desc'])){
            $query->orderBy('release_date', $request->input('sort'));
        }else{
            $query->orderBy('title', 'asc');
        }

        return response()->json($query->get(), 200);
    }


    public function show($id){
        $videoGame = VideoGame::find($id);

        if($videoGame){
            return response()->json($videoGame, 200);
        }
        return response()->json(['message' => 'Video Game not found'], 404);
    }

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
    
    public function gameDeletion($id){
        $videoGame = VideoGame::find($id);

        if(!$videoGame){
            return response()->json(['message' => 'Video game Not found'], 404);
        }

        if(auth()->user()->role === 'user' && auth()->id() !== $videoGame->user_id){
            return response()->json(["message" => "Users can only delete their own games."], 403);
        }

        $videoGame->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
        
    }
}
