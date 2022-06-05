<?php

namespace App\Http\Controllers;

use App\Superviviente;
use Illuminate\Http\Request;

class SupervivienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $superviviente;

    public function __construct(Superviviente $superviviente) {
        $this->superviviente = $superviviente;
    }

    public function index()
    {
        //
        $supervivientes = ['data' => $this->superviviente->all()];
        return response()->json($supervivientes);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function show(Superviviente $superviviente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function edit(Superviviente $superviviente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Superviviente $superviviente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Superviviente $superviviente)
    {
        //
    }
}
