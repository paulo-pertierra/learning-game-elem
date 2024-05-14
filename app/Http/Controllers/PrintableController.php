<?php

namespace App\Http\Controllers;

use App\Models\Printable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PrintableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printables = Printable::orderBy('created_at', 'DESC')->paginate(6);

        if (Auth::user()->role === 'admin') 
            return Inertia::render('Admin/Printables', [
                "printables" => $printables
            ]);
        
        else if (Auth::user()->role === 'teacher') 
            return Inertia::render('Teacher/Printables', [
                "printables" => $printables
            ]);
        else 
            return Inertia::render('Student/Printables',
            [
                "printables" => $printables
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

        $printableFile = $request->file('file');

        $path = $printableFile->store('printables');

        Printable::create([
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
        $printable = Printable::findOrFail($id);
        
        if (Auth::user()->role === 'admin') 
            return Inertia::render('Admin/Printables/View', [
                'printable' => $printable
            ]);
        else 
            return Inertia::render('Student/Printables/View', [
                'printable' => $printable
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
        $request->validate([
            'title'=> ['required', 'max:25'],
            'grade_level' => ['required', 'numeric', 'min:1', 'max:3'],
            'quarter' => ['required', 'numeric', 'min:1', 'max:4']
        ]);

        $printable = Printable::find($id);
        
        $path = $printable->file;
        $printableFile = $request->file('file');
        if (!is_null($printableFile))
            $path = $printableFile->store('printables');

        $printable->title = $request->title;
        $printable->description = $request->description;
        $printable->grade_level = $request->grade_level;
        $printable->quarter = $request->quarter;
        $printable->file = $path;

        $printable->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Printable::destroy($id);
        
        return redirect()->route('printables');
    }

    public function download(string $id) 
    {    
        $printable = Printable::findOrFail($id);
        
        return Storage::download($printable->file);
    }

    public function preview(string $id)
    {
        $printable = Printable::findOrFail($id);

        return Storage::response($printable->file);
    }
}
