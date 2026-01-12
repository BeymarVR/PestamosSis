<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $noti = Notificacion::where('id', $id)->where('usuario_id', Auth::id())->firstOrFail();
        $noti->update(['leida' => true]);
        return response()->json(['success' => true]);
    }
}
