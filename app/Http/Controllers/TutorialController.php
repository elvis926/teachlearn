<?php

namespace App\Http\Controllers;

use App\Tutorial;
use Illuminate\Http\Request;
use App\Http\Resources\Tutorial as TutorialResource;
use App\Http\Resources\TutorialCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TutorialController extends Controller
{
    private static $messages = [
        'required'=>'El compo: atribute es obligatorio',

    ];
    public function index()
    {
        $this->authorize('viewAny', Tutorial::class);
        //return response()->json(new TutorialCollection(Tutorial::all()),200);
        return new TutorialCollection(Tutorial::paginate(10));
    }
    public function show(Tutorial $tutorial)
    {
        $this->authorize('view', $tutorial);
        return response()->json(new TutorialResource($tutorial),200);
    }

    public function image(Tutorial $tutorial)
    {
        return response()->download(public_path(Storage::url($tutorial->image)), $tutorial->voucher);
    }
    public function store(Request $request)
    {

        $this->authorize('create', Tutorial::class);
        $request->validate([
            'date' => 'required|date',
            'hour' => 'required|string',
            'observation'=> 'required|string',
            'topic' =>'required|string',
            'price'=> 'required|string',
            'image' => 'required|image',
            'duration'=>'required',
            'subject_id' => 'required|exists:subjects,id',

        ]);
        $tutorial = Tutorial::create($request->all());
        $path = $request->image->store('public/tutorials');
        $tutorial->image = $path;
        $tutorial->save();
        return response()->json($tutorial, 201);

    }
    public function update(Request $request, Tutorial $tutorial)
    {
        $this->authorize('update',$tutorial);
        $request->validate([
            'date' => 'required|date',
            'hour' => 'required|string',
            'observation'=> 'required|string',
            'topic' =>'required|string',
        ],self::$messages);

        $tutorial->update($request->all());
        return response()->json($tutorial, 200);
    }

    public function accept(Request $request, Tutorial $tutorial)
    {
        $this->authorize('choose',$tutorial);
        $tutorial->teacher_id = Auth::id();
        $tutorial->save();
        return response()->json($tutorial, 200);
    }

    public function delete(Request $request, Tutorial $tutorial)
    {
        $this->authorize('delete',$tutorial);
        $tutorial->delete();
        return response()->json(null, 204);

    }
}
