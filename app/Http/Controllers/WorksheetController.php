<?php

namespace App\Http\Controllers;

use App\Models\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> ['required', 'max:25'],
            'grade_level' => ['required'],
            'quarter' => ['required']
        ]);

        $worksheetFile = $request->file('file');

        $path = $worksheetFile->store('worksheets');

        Worksheet::create([
            'file' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'grade_level' => $request->grade_level,
            'quarter' => $request->quarter
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(string $id) {
        
        $worksheet = Worksheet::findOrFail($id);
        
        return Storage::download($worksheet->file);
 
    }
}
