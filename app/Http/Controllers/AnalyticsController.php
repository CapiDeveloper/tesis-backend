<?php

namespace App\Http\Controllers;

use App\Models\EventLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index() {

        // Lugares
        $creadoLugar = EventLog::where('event_type', 'eliminar-lugar')->count();
        $actualizadoLugar = EventLog::where('event_type', 'actualizar-lugar')->count();
        $eliminadoLugar = EventLog::where('event_type', 'crear-lugar')->count();

        // Comentarios
        $creadoComentario = EventLog::where('event_type', 'crear-comentario')->count();
        $actualizadoComentario = EventLog::where('event_type', 'actualizar-comentario')->count();
        $eliminadoComentario = EventLog::where('event_type', 'eliminar-comentario')->count();

        // Producto
        $creadoProducto = EventLog::where('event_type', 'crear-producto')->count();
        $actualizadoProducto = EventLog::where('event_type', 'actualizar-producto')->count();
        $eliminadoProducto = EventLog::where('event_type', 'eliminar-producto')->count();

        // Usuarios
        $creadoUsuario = EventLog::where('event_type', 'crear-usuario')->count();
        $actualizadoUsuario = EventLog::where('event_type', 'actualizar-usuario')->count();

        // Usuarios por mes
        $usersPerMonth = User::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc') // Orden ascendente por año
        ->orderBy('month', 'asc') // Orden ascendente por mes
        ->get();

        return [
            'creadoLugar'=>$creadoLugar,
            'actualizadoLugar'=>$actualizadoLugar,
            'eliminadoLugar'=>$eliminadoLugar,
            'creadoComentario'=>$creadoComentario,
            'actualizadoComentario'=>$actualizadoComentario,
            'eliminadoComentario'=>$eliminadoComentario,
            'creadoProducto'=>$creadoProducto,
            'actualizadoProducto'=>$actualizadoProducto,
            'eliminadoProducto'=>$eliminadoProducto,
            'creadoUsuario'=>$creadoUsuario,
            'actualizadoUsuario'=>$actualizadoUsuario,
            'usersPerMonth'=>$usersPerMonth,
        ];
    }
}
