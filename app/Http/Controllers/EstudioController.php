<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EstudioController extends Controller
{
    //

    public function index() {
        $estudios = auth()->user()->estudios;
        return view('dashboard', compact('estudios'));
    }

    public function create()
    {
        return view('estudio.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'objetivo' => 'required',
            'objetivos_especificos' => 'required',
            'especificacion' => 'required',
        ]);

        $user = Auth::user();
        $user->estudios()->create($data);

        return redirect('/dashboard');
    }

    public function show(Estudio $estudio)
    {
        return view('estudio.show', compact('estudio'));
    }

    public function update(Request $request, $id)
    {
        $estudio = Estudio::find($id);
        $input = $request->all();
        //print_r($input);
        $estudio->update($input);
        return redirect('/estudios/'.$estudio->id.'/detalles');
    }

    public function delete($id){
        Estudio::destroy($id);
        return redirect('/dashboard')->with('eliminar', 'ok');
    }
}
