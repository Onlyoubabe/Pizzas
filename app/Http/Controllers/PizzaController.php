<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all();
        return view('pizzas', compact('pizzas'));
    }

    public function menu()
{
    $pizzas = Pizza::all();
    return view('menu', compact('pizzas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('pizzas', 'public');
        }

        Pizza::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath
        ]);

        return redirect()->route('pizzas.index')->with('success', 'Pizza registrada con éxito');
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->route('pizzas.index')->with('success', 'Pizza eliminada');
    }

    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('pizzas', 'public');
            $pizza->imagen = $imagenPath;
        }

        $pizza->update($request->only('nombre', 'descripcion', 'precio'));

        return redirect()->route('pizzas.index')->with('success', 'Pizza actualizada');
    }
}
