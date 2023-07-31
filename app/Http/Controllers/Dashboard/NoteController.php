<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return inertia('Notes/Index', [
            'notes' => Note::all(),
        ]);
    }

    public function store(NoteRequest $request)
    {
        Note::create($request->validated());

        return back();
    }

    public function update(NoteRequest $request, $note)
    {
        Note::where('id', $note)->update($request->validated());

        return back();
    }

    public function destroy($note)
    {
        Note::where('id', $note)->delete();

        return back();
    }
}
