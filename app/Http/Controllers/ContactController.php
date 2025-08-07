<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contacto');
    }
    
    public function sendMessage(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        try {
            // Enviar el correo electrónico
            Mail::to(env('MAIL_FROM_ADDRESS', 'carlospizzasutgz@gmail.com'))
                ->send(new ContactMail($validatedData));
                
            // Redirigir con mensaje de éxito
            return redirect()->route('contacto')
                ->with('success', 'Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo pronto.');
                
        } catch (\Exception $e) {
            // Manejar errores
            return redirect()->route('contacto')
                ->with('error', 'No se pudo enviar el mensaje. Por favor, inténtalo de nuevo más tarde.')
                ->withInput();
        }
    }
}