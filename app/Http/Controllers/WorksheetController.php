<?php

namespace App\Http\Controllers;

use App\Models\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $worksheets = Worksheet::paginate(15);

        if (Auth::user()->role === 'admin') 
            return Inertia::render('Admin/Worksheets', [
                "worksheets" => $worksheets
            ]);

        else 
            return Inertia::render('Student/Worksheets',
            [
                "worksheets" => $worksheets
            ]);
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
            'file' => ['required'],
            'grade_level' => ['required', 'numeric', 'min:1', 'max:3'],
            'quarter' => ['required', 'numeric', 'min:1', 'max:4']
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
        $worksheet = Worksheet::findOrFail($id);
        
        if (Auth::user()->role === 'admin') 
            return Inertia::render('Admin/Worksheets/View', [
                'worksheet' => $worksheet
            ]);
        else 
            return Inertia::render('Student/Worksheets/View', [
                'worksheet' => $worksheet
            ]);
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

        $worksheet = Worksheet::find($id);

        $request->validate([
            'title'=> ['required', 'max:25'],
            'grade_level' => ['required', 'numeric', 'min:1', 'max:3'],
            'quarter' => ['required', 'numeric', 'min:1', 'max:4']
        ]);

        $worksheet->title = $request->title;
        $worksheet->description = $request->description;
        $worksheet->grade_level = $request->grade_level;
        $worksheet->quarter = $request->quarter;

        $worksheet->save();

        $worksheetFile = $request->file('file');
        
        if (is_null($worksheetFile)) return;
        $path = $worksheetFile->store('worksheets');
        
        $worksheet->file = $path;
        $worksheet->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Worksheet::destroy($id);
    }

    public function download(string $id) {
        
        $worksheet = Worksheet::findOrFail($id);
        
        return Storage::download($worksheet->file);
 
    }
}
