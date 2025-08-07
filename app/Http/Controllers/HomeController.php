<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class HomeController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all(); // O puedes usar Pizza::take(6)->get(); para mostrar solo 6 pizzas
        return view('home', compact('pizzas'));
    }
}