<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->paginate(6);

        if (Auth::user()->role === 'admin') 
            return Inertia::render('Admin/Videos', [
                "videos" => $videos
            ]);

        else 
            return Inertia::render('Student/Videos',
            [
                "videos" => $videos
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'link' => ['required'],
            'title' => ['required', 'max:50'],
            'grade_level' => ['required', 'numeric', 'min:1', 'max:3'],
            'quarter' => ['required', 'numeric', 'min:1', 'max:4']
        ]);

        Video::create([
            'link' => $request->link,
            'title' => $request->title,
            'description' => $request->description,
            'grade_level' => $request->grade_level,
            'quarter' => $request->quarter,
            'user_id' => Auth::user()->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }
}
