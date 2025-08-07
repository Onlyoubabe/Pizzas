<?php
// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private function getSessionId()
    {
        return session('cart_session_id', Str::uuid());
    }
    
    // Procesar el pago
    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);
        
        $userId = Auth::id();
        $sessionId = $this->getSessionId();
        
        $cartItems = CartItem::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('pizza')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Tu carrito está vacío');
        }
        
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->pizza->precio;
        });
        
        // Crear orden
        $order = Order::create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'pending',
            'address' => $request->address,
            'phone' => $request->phone,
            'notes' => $request->notes
        ]);
        
        // Crear items de la orden
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'pizza_id' => $item->pizza_id,
                'quantity' => $item->quantity,
                'price' => $item->pizza->precio
            ]);
        }
        
        // Guardar ID de orden en sesión para procesar después
        session(['pending_order_id' => $order->id]);
        
        // Parámetros para PayPal
        $paypalParams = [
            'order_id' => $order->id,
            'total' => $total,
            'currency' => 'USD',
            'return_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel')
        ];
        
        return view('payment-paypal', compact('paypalParams'));
    }
    
    // Procesar pago exitoso
    public function success(Request $request)
    {
        $orderId = session('pending_order_id');
        
        if (!$orderId) {
            return redirect()->route('menu')->with('error', 'No se encontró la orden');
        }
        
        $order = Order::findOrFail($orderId);
        
        // Actualizar orden como pagada
        $order->update([
            'status' => 'paid',
            'payment_id' => $request->get('paymentId', 'PAYPAL-'.Str::random(10))
        ]);
        
        // Limpiar carrito
        $userId = Auth::id();
        $sessionId = $this->getSessionId();
        
        CartItem::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();
        
        // Limpiar la sesión
        session()->forget(['pending_order_id', 'cart_session_id']);
        
        return redirect()->route('order.confirmation', $order->id);
    }
    
    // Procesar cancelación de pago
    public function cancel()
    {
        $orderId = session('pending_order_id');
        
        if ($orderId) {
            $order = Order::findOrFail($orderId);
            $order->update(['status' => 'cancelled']);
        }
        
        return redirect()->route('cart.index')->with('error', 'El pago ha sido cancelado');
    }
}