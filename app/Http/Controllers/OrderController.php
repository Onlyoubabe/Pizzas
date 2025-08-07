<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Mostrar la confirmación de la orden
    public function confirmation(Order $order)
    {
        // Verificar autorización sin usar isAdmin() ni isEmpleado()
        if (!$this->canAccessOrder($order)) {
            abort(403, 'No autorizado');
        }
        
        return view('order-confirmation', compact('order'));
    }
    
    // Listar órdenes del usuario
    public function index()
    {
        // Obtener órdenes sin usar la relación orders()
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders', compact('orders'));
    }
    
    // Ver detalle de una orden
    public function show(Order $order)
    {
        // Verificar autorización sin usar isAdmin() ni isEmpleado()
        if (!$this->canAccessOrder($order)) {
            abort(403, 'No autorizado');
        }
        
        return view('order-detail', compact('order'));
    }
    
    public function adminIndex()
    {
        // Verificar si el usuario está autenticado y tiene el rol de "admin" o "empleado"
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'empleado'])) {
            abort(403, 'No autorizado');
        }
        
        $orders = Order::with('user')->latest()->get();
        // Usar la nueva vista admin_orders
        return view('admin_orders', compact('orders'));
    }
    // Actualizar estado de la orden (admin)
    public function updateStatus(Request $request, Order $order)
    {
        // Verificar si es admin o empleado sin usar isAdmin() ni isEmpleado()
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'empleado'])) {
            abort(403, 'No autorizado');
        }
        
        $request->validate([
            'status' => 'required|in:pending,paid,preparing,delivering,completed,cancelled'
        ]);
        
        $order->update(['status' => $request->status]);
        
        return back()->with('success', 'Estado de la orden actualizado');
    }
    
    // Método auxiliar para verificar si un usuario puede acceder a una orden
    private function canAccessOrder(Order $order)
    {
        if (!Auth::check()) {
            return false;
        }
        
        // Es el dueño de la orden
        if (Auth::id() === $order->user_id) {
            return true;
        }
        
        // Es admin o empleado
        return in_array(Auth::user()->role, ['admin', 'empleado']);
    }
}