<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\Subject as SubjectResource;

class SubjectController extends Controller
{

    private static $messages = [
        'required'=>'El campo: atribute es obligatorio',
    ];
    public function index()
    {
        $this->authorize('viewAny', Subject::class);
        return Subject::all();
    }
    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);
        return response()->json(new SubjectResource($subject),200);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Subject::class);
        $request->validate([
            'name' => 'required|string',
            'level' => 'required|string',
        ], self::$messages);

        $subject = Subject::create($request->all());
        return response()->json($subject, 201);
    }
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update',$subject);
        $request->validate([
            'level' => 'required|string',
        ],self::$messages);
        $subject->update($request->all());
        return response()->json($subject, 200);
    }
    public function delete(Request $request, Subject $subject)
    {
        $this->authorize('delete',$subject);
        $subject->delete();
        return response()->json(null, 204);
    }

}
