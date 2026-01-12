<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Cache;

class RFIDController extends Controller
{
    // Almacena temporalmente el último UID verificado (5 minutos)
    public function verify(Request $request)
    {
        // Validar entrada JSON
        $data = $request->json()->all();
        
        if (!isset($data['uid']) || empty(trim($data['uid']))) {
            return response()->json([
                'success' => false,
                'message' => 'Esperando escaneo...'
            ]);
        }
        
        $uid = trim($data['uid']);
        $uid = strtoupper($uid); // Asegurar mayúsculas: 81:01:AB:5D
        
        // Buscar usuario por UID RFID
        $usuario = Usuario::where('rfid_uid', $uid)
                          ->where('activo', true)
                          ->first();
        
        if (!$usuario) {
            // Limpiar cache si la tarjeta no es válida
            Cache::forget('last_rfid_scan');
            
            return response()->json([
                'success' => false,
                'message' => 'Tarjeta no registrada o usuario inactivo'
            ], 404);
        }
        
        // Verificar si es admin o gestor (rol_id 1 o 2)
        if (!in_array($usuario->rol_id, [1, 2])) {
            Cache::forget('last_rfid_scan');
            
            return response()->json([
                'success' => false,
                'message' => 'No tiene permisos de administrador/gestor'
            ], 403);
        }
        
        // Obtener nombre del rol
        $rol = Rol::find($usuario->rol_id);
        
        // Guardar en cache por 5 minutos
        $scanData = [
            'user_id' => $usuario->id,
            'uid' => $uid,
            'nombre' => $usuario->nombre_completo,
            'rol' => $rol ? $rol->nombre : 'Desconocido',
            'timestamp' => now()->timestamp
        ];
        
        Cache::put('last_rfid_scan', $scanData, 300); // 5 minutos
        
        // Éxito - usuario autorizado
        return response()->json([
            'success' => true,
            'message' => 'Acceso autorizado',
            'user' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre_completo,
                'rol' => $rol ? $rol->nombre : 'Desconocido'
            ]
        ]);
    }
    
    // Para el frontend: verificar si hay un escaneo reciente
    public function checkScan(Request $request)
    {
        $scanData = Cache::get('last_rfid_scan');
        
        if (!$scanData) {
            return response()->json([
                'success' => false,
                'message' => 'Esperando escaneo de tarjeta...'
            ]);
        }
        
        // Verificar que no haya pasado más de 30 segundos
        $currentTime = now()->timestamp;
        $scanTime = $scanData['timestamp'];
        
        if (($currentTime - $scanTime) > 30) { // 30 segundos de validez
            Cache::forget('last_rfid_scan');
            
            return response()->json([
                'success' => false,
                'message' => 'Escaneo expirado. Acerca la tarjeta nuevamente.'
            ]);
        }
        
        // Éxito - devolver datos del escaneo
        return response()->json([
            'success' => true,
            'message' => 'Tarjeta verificada',
            'user' => [
                'id' => $scanData['user_id'],
                'nombre' => $scanData['nombre'],
                'rol' => $scanData['rol']
            ],
            'uid' => $scanData['uid']
        ]);
    }
    
    // Limpiar escaneo (cuando se cancela)
    public function clearScan(Request $request)
    {
        Cache::forget('last_rfid_scan');
        
        return response()->json([
            'success' => true,
            'message' => 'Escaneo limpiado'
        ]);
    }
}