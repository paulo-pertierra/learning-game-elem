<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameAnswer;
use App\Models\GameQuestion;
use App\Models\GameScore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index() {

        $games = Game::paginate(6);

        if (Auth::user()->role === 'admin')
            return Inertia::render('Admin/Games', [
                'games' => $games
            ]);
        if (Auth::user()->role === 'teacher')
            return Inertia::render('Teacher/Games', [
                'games' => $games
            ]);
        if (Auth::user()->role === 'student')
            return Inertia::render('Student/Games', [
                'games' => $games
            ]);
    }

    public function build() {
        if (Auth::user()->role === 'admin')
            return Inertia::render('Admin/Games/Build');
        if (Auth::user()->role === 'teacher')
            return Inertia::render('Teacher/Games/Build');
    }

    public function store(Request $request) {

        $game = Game::create($request->game);
        
        $gameQuestions = $request->questions;


        $createdQuestions = [];
        $createdAnswers = [];

        foreach($gameQuestions as $gameQuestion) {
            $gameQuestion['game_id'] = $game->id;
            $gameAnswers = $gameQuestion['answers'];

            $createdQuestion = $game->gameQuestion()->create($gameQuestion);

            foreach ($gameAnswers as $gameAnswer) {
                $gameAnswer['question_id'] = $createdQuestion->id;
                $createdQuestion->gameAnswer()->create($gameAnswer);
            }

        }

        return;
    }

    public function show($id) {
        $game = Game::find($id);
        $questions = $game->gameQuestion;

        if (Auth::user()->role == 'teacher')
        return Inertia::render('Teacher/Games/Play', [
            "game" => $game
        ]);

        return;
    }

    public function question(Request $request, $id, $itemNo)
    {
        $game = Game::find($id);
        $question = GameQuestion::query()->where('game_id', $id)->where('item_no', $itemNo)->first();
        $answers = GameAnswer::query()->where('game_question_id', $question->id)->inRandomOrder()->get();
        return Inertia::render('Teacher/Games/Play/Question', [
            "game" => $game,
            "question" => $question,
            "answers" => $answers,
        ]);
    }

    public function submit(Request $request, $id)
    {
        // $user = User::findOrFail(Auth::user()->id);
        // $gameId = $id;

        // $game = Game::findOrFail($gameId);

        // $score = 0;
        // foreach ($answers as $answer) {
        //     $answerModel = GameAnswer::find($answer);
        //     if ($answerModel->is_correct == true) $score +=1;
        // }

        // $gameScore = GameScore::create([
        //     "score" => $score,
        //     "total_questions" => $game->total_questions
        // ]);

        // $gameScore->user_id = $user->id;
        // $gameScore->game_id = $game->id;
        // $gameScore->save();
        
        return Inertia::render('Teacher/Games/End');
    }

    public function end($id)
    {   
        $game = Game::find($id);
        return Inertia::render('Teacher/Games/End', [
            'game' => $game
        ]);
    }
}
