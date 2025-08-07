<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Pizza;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Obtener o crear ID de sesión para usuarios no autenticados
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()]);
        }
        return session('cart_session_id');
    }

    // Mostrar el carrito
    public function index()
    {
        $userId = Auth::id();
        $sessionId = $this->getSessionId();
        
        $cartItems = CartItem::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('pizza')->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->pizza->precio;
        });
        
        return view('cart', compact('cartItems', 'total'));
    }

    // Agregar al carrito
    public function add(Request $request)
    {
        $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $userId = Auth::id();
        $sessionId = $this->getSessionId();
        
        // Buscar si ya existe en el carrito
        $cartItem = CartItem::where('pizza_id', $request->pizza_id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();
        
        if ($cartItem) {
            // Actualizar cantidad
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Crear nuevo item
            CartItem::create([
                'user_id' => $userId,
                'pizza_id' => $request->pizza_id,
                'quantity' => $request->quantity,
                'session_id' => $userId ? null : $sessionId
            ]);
        }
        
        return back()->with('success', 'Pizza añadida al carrito');
    }

    // Actualizar cantidad
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return back()->with('success', 'Carrito actualizado');
    }

    // Eliminar del carrito
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item eliminado del carrito');
    }

    // Proceder al checkout
    public function checkout()
    {
        $userId = Auth::id();
        $sessionId = $this->getSessionId();
        
        $cartItems = CartItem::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('pizza')->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->pizza->precio;
        });
        
        return view('checkout', compact('cartItems', 'total'));
    }
}