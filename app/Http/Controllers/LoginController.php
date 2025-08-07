<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'El correo ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'usuario', // Por defecto, los nuevos usuarios son "usuario"
        ]);
        
        Auth::login($user);
        // Redirigir al menú para los usuarios normales
        return redirect()->route('menu')->with('success', 'Registro exitoso, bienvenido!');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
    
        if (Auth::attempt($credentials, $remember)) {
            // Redirigir según el rol del usuario
            if (Auth::user()->role === 'admin') {
                return redirect()->route('pizzas.index')->with('success', 'Inicio de sesión exitoso.');
            } elseif (Auth::user()->role === 'empleado') {
                return redirect()->route('pizzas.index')->with('success', 'Inicio de sesión exitoso.');
            } else {
                return redirect()->route('menu')->with('success', 'Inicio de sesión exitoso.');
            }
        }
    
        return back()->withErrors(['email' => 'Las credenciales no son correctas.'])->withInput();
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

    

    // Métodos para autenticación con Google
    
    /**
     * Redirige al usuario a la página de autenticación de Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtiene la información del usuario de Google y lo autentica/registra.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar si el usuario ya existe con este google_id
            $existingUser = User::where('google_id', $googleUser->id)->first();
            
            // O buscar si existe un usuario con el mismo email
            if (!$existingUser) {
                $existingUser = User::where('email', $googleUser->email)->first();
            }
            
            if ($existingUser) {
                // Si el usuario existe pero no tiene google_id, actualizar
                if (empty($existingUser->google_id)) {
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar
                    ]);
                }
                
                Auth::login($existingUser);
            } else {
                // Crear un nuevo usuario
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(Str::random(16)), // Contraseña aleatoria ya que no se usará
                    'role' => 'usuario', // Asignar rol de usuario como solicitaste
                ]);
                
                Auth::login($newUser);
            }
            
            // Redirigir según el rol
            if (Auth::user()->role === 'admin') {
                return redirect()->route('pizzas.index')->with('success', 'Inicio de sesión con Google exitoso.');
            } elseif (Auth::user()->role === 'empleado') {
                return redirect()->route('pizzas.index')->with('success', 'Inicio de sesión con Google exitoso.');
            } else {
                return redirect()->route('menu')->with('success', 'Inicio de sesión con Google exitoso.');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Error al iniciar sesión con Google: ' . $e->getMessage()]);
        }
    }
}