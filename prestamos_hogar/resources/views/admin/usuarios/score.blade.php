@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded shadow max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-slate-800">Score crediticio de {{ $usuario->nombre_completo }}</h2>

    <div class="mb-4 text-lg">
        <p><strong>Score actual:</strong> 
            <span class="text-blue-700 text-xl font-semibold">{{ $score }}/100</span>
        </p>
        <p><strong>Nivel de riesgo:</strong> 
            @if($score >= 80)
                <span class="text-green-600">Cliente confiable</span>
            @elseif($score >= 60)
                <span class="text-yellow-500">Responsable</span>
            @elseif($score >= 40)
                <span class="text-orange-500">Inestable</span>
            @else
                <span class="text-red-600">Riesgoso</span>
            @endif
        </p>
    </div>

    <a href="{{ route('admin.prestamos.index') }}" class="text-sm text-blue-600 underline hover:text-blue-800">← Volver</a>
</div>
@endsection
