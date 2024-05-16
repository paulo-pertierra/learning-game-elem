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
        $gradeLevel = Auth::user()->grade_level;
        $videos = Video::orderBy('created_at', 'DESC')->paginate(6);
        $videosFiltered = Video::where('grade_level', '=', $gradeLevel)->orderBy('created_at', 'DESC')->paginate(6);

        if (Auth::user()->role === 'admin')
            return Inertia::render('Admin/Videos', [
                "videos" => $videos
            ]);
        else if (Auth::user()->role === 'teacher')
            return Inertia::render('Teacher/Videos', [
                "videos" => $videosFiltered
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

        return redirect()->to('/videos');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $video = Video::findOrFail($id);

        if (Auth::user()->role === 'admin')
            return Inertia::render('Admin/Videos/View', [
                'video' => $video
            ]);
        else
            return Inertia::render('Teacher/Videos/View', [
                'video' => $video
            ]);
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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'link' => ['required'],
            'title' => ['required', 'max:50'],
            'grade_level' => ['required', 'numeric', 'min:1', 'max:3'],
            'quarter' => ['required', 'numeric', 'min:1', 'max:4']
        ]);

        $video = Video::findOrFail($id);

        $video->link = $request->link;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->grade_level = $request->grade_level;
        $video->quarter = $request->quarter;

        $video->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Video::destroy($id);

        return redirect()->route('videos');
    }
}
