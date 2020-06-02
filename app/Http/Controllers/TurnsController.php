<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turn;

class TurnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turn = Turn::where('status',1)->where('user_id',auth()->id())->orderBy('id')->first();
        if (empty($turn)) {
            $turn = Turn::where('status',0)->orderBy('id')->first();
        }
        if (!empty($turn)) {
           $turn->update(['user_id'=>auth()->id(),'status'=>1]);
        }
        $turns = Turn::where('status','>',0)->orderBy('id','desc')->limit(5)->get();
        return view('home')->with('turn',$turn)->with('turns',$turns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'venue_id' => 'required',
        ]);

        $turn = new Turn();
        $turn->status=0;
        $turn->venue_id=$request->venue_id;
        if ($turn->save()) {
            return response()->json(['success'=>true, 'turn'=>Turn::with('user')->find($turn->id)]);
        }
        return response()->json(['success'=>false, 'error'=>'No se pudo generar el turno. intente de nuevo'],500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $turn = Turn::findOrFail($id);

        $turn->fill($request->all());

        if ($turn->save()) {
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false, 'error'=>'No se pudo guardar. intente de nuevo'],500);
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Turn::with('user')->findOrFail($id);
    }
}
