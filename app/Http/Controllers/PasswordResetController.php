<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    // Mostrar formulario de olvidó la contraseña
    public function showForgotPasswordForm()
    {
        return view('forgotPassword');
    }

    // Enviar enlace de restablecimiento
    public function sendResetLinkEmail(Request $request)
    {
        // Validar el correo
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Verificar si el correo está registrado en la base de datos
        $user = \App\Models\User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'Este correo no está registrado en nuestra plataforma.']);
        }
    
        // Enviar el enlace para restablecer la contraseña
        $status = Password::sendResetLink($request->only('email'));
    
        // Retornar respuesta según el estado
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', 'Se ha enviado el enlace de restablecimiento al correo electrónico.')
            : back()->withErrors(['email' => 'No se pudo enviar el enlace de restablecimiento.']);
    }
    

    // Mostrar formulario de restablecimiento de contraseña
    public function showResetPasswordForm($token)
    {
        return view('resetPassword', ['token' => $token]);
    }

    // Restablecer la contraseña
    public function resetPassword(Request $request)
    {
        // Validar los datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // Intentar restablecer la contraseña
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = bcrypt($request->password);
                $user->save();
            }
        );

        // Verificar el estado del restablecimiento
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Contraseña restablecida con éxito.')
                    : back()->withErrors(['email' => 'El enlace de restablecimiento es inválido o expiró.']);
    }
}
