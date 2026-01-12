@extends('layouts.app')

@section('page-title', 'Score Crediticio IA')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
    <div class="max-w-7xl mx-auto space-y-8">
        
        @if ($error_api)
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 text-yellow-800 p-6 rounded-xl shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="font-semibold">{{ $error_api }}</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.usuarios.index') }}" 
                   class="p-3 text-slate-500 hover:text-slate-700 hover:bg-white rounded-xl transition-all duration-200 shadow-sm border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-800">Score Crediticio IA</h1>
                        <p class="mt-1 text-lg text-slate-600">{{ $usuario->nombre_completo }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.usuarios.show', $usuario->id) }}" 
                   class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Ver Perfil</span>
                </a>
                <a href="{{ route('admin.usuarios.historial', $usuario->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 flex items-center space-x-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Historial</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Score Principal -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-10 text-center relative overflow-hidden">
                    @php
                        // Determinar el nivel de riesgo
                        if ($scoreIA >= 80) {
                            $nivel = 'confiable';
                            $colorPrimario = 'emerald';
                            $gradiente = 'from-emerald-500 to-teal-600';
                            $bgColor = 'bg-emerald-100';
                            $textColor = 'text-emerald-800';
                            $strokeColor = '#10b981';
                        } elseif ($scoreIA >= 60) {
                            $nivel = 'moderado';
                            $colorPrimario = 'yellow';
                            $gradiente = 'from-yellow-500 to-orange-500';
                            $bgColor = 'bg-yellow-100';
                            $textColor = 'text-yellow-800';
                            $strokeColor = '#f59e0b';
                        } else {
                            $nivel = 'riesgoso';
                            $colorPrimario = 'red';
                            $gradiente = 'from-red-500 to-rose-600';
                            $bgColor = 'bg-red-100';
                            $textColor = 'text-red-800';
                            $strokeColor = '#ef4444';
                        }
                    @endphp

                    <!-- Elementos decorativos -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $gradiente }} opacity-10 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr {{ $gradiente }} opacity-10 rounded-full -ml-12 -mb-12"></div>

                    <!-- Indicador de Nivel de Riesgo -->
                    <div class="mb-6">
                        @if($nivel == 'confiable')
                            <div class="inline-flex items-center px-4 py-2 rounded-full {{ $bgColor }} {{ $textColor }} font-bold text-lg shadow-lg">
                                <span class="text-2xl mr-2">🟢</span>
                                Confiable
                            </div>
                        @elseif($nivel == 'moderado')
                            <div class="inline-flex items-center px-4 py-2 rounded-full {{ $bgColor }} {{ $textColor }} font-bold text-lg shadow-lg">
                                <span class="text-2xl mr-2">🟡</span>
                                Riesgo Moderado
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-2 rounded-full {{ $bgColor }} {{ $textColor }} font-bold text-lg shadow-lg">
                                <span class="text-2xl mr-2">🔴</span>
                                Riesgoso
                            </div>
                        @endif
                    </div>

                    <div class="relative inline-flex items-center justify-center w-40 h-40 mb-8">
                        <!-- Círculo de progreso -->
                        <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" stroke="#e2e8f0" stroke-width="8" fill="none"/>
                            <circle cx="60" cy="60" r="50" 
                                    stroke="{{ $strokeColor }}" 
                                    stroke-width="8" 
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ 2 * pi() * 50 }}"
                                    stroke-dashoffset="{{ 2 * pi() * 50 * (1 - $scoreIA / 100) }}"
                                    class="transition-all duration-2000 ease-out"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-4xl font-bold {{ $textColor }}">
                                    {{ number_format($scoreIA, 0) }}
                                </div>
                                <div class="text-lg text-slate-500 font-semibold">/ 100</div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Score Crediticio</h3>
                    
                    <p class="text-slate-600 leading-relaxed">
                        @if($scoreIA >= 80)
                            Cliente con excelente historial crediticio y muy bajo riesgo de impago. Perfil ideal para productos premium.
                        @elseif($scoreIA >= 60)
                            Cliente con buen historial crediticio y riesgo moderado. Requiere evaluación estándar.
                        @else
                            Cliente con historial crediticio que requiere evaluación exhaustiva y garantías adicionales.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Factores del Score -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">
                    <h3 class="text-2xl font-bold text-slate-800 mb-8 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Factores de Evaluación
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Porcentaje de pagos a tiempo -->
                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Pagos a Tiempo</h4>
                                    <p class="text-emerald-700 font-semibold">Historial de cumplimiento</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-emerald-700">{{ number_format($porcentaje, 1) }}%</div>
                                <div class="text-sm text-emerald-600 font-semibold">de puntualidad</div>
                            </div>
                        </div>

                        <!-- Cantidad de moras -->
                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-red-50 to-rose-50 rounded-2xl border border-red-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-r from-red-500 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Incidencias de Mora</h4>
                                    <p class="text-red-700 font-semibold">Pagos con retraso</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-red-700">{{ $cantidadMoras }}</div>
                                <div class="text-sm text-red-600 font-semibold">incidencias</div>
                            </div>
                        </div>

                        <!-- Antigüedad -->
                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Antigüedad del Cliente</h4>
                                    <p class="text-blue-700 font-semibold">Tiempo en el sistema</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-blue-700">{{ intval($antiguedadDias) }}</div>
                                <div class="text-sm text-blue-600 font-semibold">días</div>
                            </div>
                        </div>

                        <!-- Cantidad de préstamos -->
                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-violet-50 to-purple-50 rounded-2xl border border-violet-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-r from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Experiencia Crediticia</h4>
                                    <p class="text-violet-700 font-semibold">Préstamos gestionados</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-violet-700">{{ $cantidadPrestamos }}</div>
                                <div class="text-sm text-violet-600 font-semibold">préstamos</div>
                            </div>
                        </div>

                        <!-- Monto promedio -->
                        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl border border-orange-200 shadow-sm">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">Capacidad de Pago</h4>
                                    <p class="text-orange-700 font-semibold">Monto promedio solicitado</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-orange-700">Bs {{ number_format($montoPromedio, 0) }}</div>
                                <div class="text-sm text-orange-600 font-semibold">promedio</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recomendaciones del Sistema IA -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8">
            <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                Recomendaciones del Sistema IA
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($scoreIA >= 80)
                    <div class="p-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-emerald-900 text-lg">Cliente Preferencial</h4>
                                <p class="text-emerald-700 mt-2 leading-relaxed">Aprobar préstamos con tasas preferenciales y condiciones especiales.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900 text-lg">Oportunidad de Crecimiento</h4>
                                <p class="text-blue-700 mt-2 leading-relaxed">Ofrecer productos premium y líneas de crédito ampliadas con beneficios exclusivos.</p>
                            </div>
                        </div>
                    </div>
                @elseif($scoreIA >= 60)
                    <div class="p-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-yellow-900 text-lg">Evaluación Adicional</h4>
                                <p class="text-yellow-700 mt-2 leading-relaxed">Revisar ingresos y garantías antes de aprobar montos altos. Solicitar documentación adicional.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900 text-lg">Plan de Mejora</h4>
                                <p class="text-blue-700 mt-2 leading-relaxed">Incentivar pagos puntuales para mejorar el score crediticio y acceder a mejores condiciones.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-900 text-lg">Alto Riesgo</h4>
                                <p class="text-red-700 mt-2 leading-relaxed">Rechazar préstamos grandes. Solo microcréditos con garantías sólidas y avalistas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 rounded-2xl shadow-lg">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-orange-900 text-lg">Programa de Recuperación</h4>
                                <p class="text-orange-700 mt-2 leading-relaxed">Implementar educación financiera y seguimiento personalizado para mejorar el perfil crediticio.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Recomendaciones personalizadas -->
            @if(isset($recomendaciones) && $recomendaciones)
                <div class="mt-8 p-6 bg-gradient-to-r from-slate-50 to-slate-100 rounded-2xl border border-slate-200">
                    <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recomendaciones Personalizadas:
                    </h4>
                    <ul class="space-y-3">
                        @foreach($recomendaciones as $reco)
                            <li class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-gradient-to-r from-violet-500 to-purple-600 rounded-full mt-2 flex-shrink-0"></div>
                                <span class="text-slate-700 leading-relaxed">{{ $reco }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
