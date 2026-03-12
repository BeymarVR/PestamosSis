@extends('layouts.app')

@section('content')
<div class="notifications-panel-container">
    <!-- Header del Panel -->
    <div class="notifications-panel-header">
        <div class="header-content">
            <h2 class="panel-title">
                <svg class="panel-title-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.19 14,4.29 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"/>
                </svg>
                Notificaciones
            </h2>
            
            @php
                $totalNotificaciones = $notificaciones->count();
                $noLeidas = $notificaciones->where('leida', false)->count();
                $moras = $notificaciones->where('tipo', 'mora')->count();
                $pagos = $notificaciones->where('tipo', 'pago')->count();
            @endphp
            
            <div class="panel-stats">
                <span class="stat-item">
                    <span class="stat-number">{{ $totalNotificaciones }}</span>
                    <span class="stat-label">Total</span>
                </span>
                @if($noLeidas > 0)
                    <span class="stat-item unread">
                        <span class="stat-number">{{ $noLeidas }}</span>
                        <span class="stat-label">Sin leer</span>
                    </span>
                @endif
                @if($moras > 0)
                    <span class="stat-item mora">
                        <span class="stat-number">{{ $moras }}</span>
                        <span class="stat-label">Moras</span>
                    </span>
                @endif
                @if($pagos > 0)
                    <span class="stat-item pago">
                        <span class="stat-number">{{ $pagos }}</span>
                        <span class="stat-label">Pagos</span>
                    </span>
                @endif
            </div>
        </div>
        
        @if($noLeidas > 0)
            <div class="panel-actions">
                <button onclick="marcarTodasLeidas()" class="mark-all-read-btn">
                    <svg class="btn-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
                    </svg>
                    Marcar todas como leídas
                </button>
            </div>
        @endif
    </div>

    <!-- Filtros -->
    <div class="notifications-filters">
        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filtrarNotificaciones('todas')">
                Todas ({{ $totalNotificaciones }})
            </button>
            @if($noLeidas > 0)
                <button class="filter-tab" onclick="filtrarNotificaciones('no-leidas')">
                    Sin leer ({{ $noLeidas }})
                </button>
            @endif
            @if($moras > 0)
                <button class="filter-tab mora-tab" onclick="filtrarNotificaciones('mora')">
                    Moras ({{ $moras }})
                </button>
            @endif
            @if($pagos > 0)
                <button class="filter-tab pago-tab" onclick="filtrarNotificaciones('pago')">
                    Pagos ({{ $pagos }})
                </button>
            @endif
            <button class="filter-tab" onclick="filtrarNotificaciones('leidas')">
                Leídas ({{ $totalNotificaciones - $noLeidas }})
            </button>
        </div>
    </div>

    <!-- Lista de Notificaciones -->
    <div class="notifications-list">
        @forelse($notificaciones as $notificacion)
            <div class="notification-card {{ $notificacion->leida ? 'read' : 'unread' }}" 
                 data-id="{{ $notificacion->id }}"
                 data-status="{{ $notificacion->leida ? 'read' : 'unread' }}"
                 data-tipo="{{ $notificacion->tipo ?? 'general' }}"
                 onclick="marcarLeida({{ $notificacion->id }})">
                
                <div class="notification-card-content">
                    <!-- Indicador de estado -->
                    <div class="notification-status-indicator">
                        @if(!$notificacion->leida)
                            <div class="status-dot unread-dot"></div>
                        @else
                            <div class="status-dot read-dot">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Icono por tipo -->
                    <div class="notification-type-icon">
                        @php
                            $tipo = $notificacion->tipo ?? 'general';
                        @endphp
                        
                        @switch($tipo)
                            @case('mora')
                                <div class="type-icon mora-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12,2C13.1,2 14,2.9 14,4C14,5.1 13.1,6 12,6C10.9,6 10,5.1 10,4C10,2.9 10.9,2 12,2M21,9V7L15,1H5C3.89,1 3,1.89 3,3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V9M19,19H5V3H13V9H19V19M12,17.5L10.25,16H9.5V14.5H10.25L12,13L13.75,14.5H14.5V16H13.75L12,17.5Z"/>
                                    </svg>
                                </div>
                                @break
                            @case('prestamo')
                                <div class="type-icon loan-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M11.8,10.9C9.53,10.31 8.8,9.7 8.8,8.75C8.8,7.66 9.81,6.9 11.5,6.9C13.28,6.9 13.94,7.75 14,9H16.21C16.14,7.28 15.09,5.7 13,5.19V3H10V5.16C8.06,5.58 6.5,6.84 6.5,8.77C6.5,11.08 8.41,12.23 11.2,12.9C13.7,13.5 14.2,14.38 14.2,15.31C14.2,16 13.71,17.1 11.5,17.1C9.44,17.1 8.63,16.18 8.5,15H6.32C6.44,17.19 8.08,18.42 10,18.83V21H13V18.85C14.95,18.5 16.5,17.35 16.5,15.3C16.5,12.46 14.07,11.5 11.8,10.9Z"/>
                                    </svg>
                                </div>
                                @break
                            @case('pago')
                                <div class="type-icon payment-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
                                    </svg>
                                </div>
                                @break
                            @case('vencimiento')
                                <div class="type-icon due-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"/>
                                    </svg>
                                </div>
                                @break
                            @default
                                <div class="type-icon general-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"/>
                                    </svg>
                                </div>
                        @endswitch
                    </div>

                    <!-- Contenido de la notificación -->
                    <div class="notification-content">
                        <div class="notification-message">
                            {{ $notificacion->mensaje }}
                        </div>
                        
                        <div class="notification-meta">
                            <span class="notification-time">
                                <svg class="time-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                                </svg>
                                {{ $notificacion->created_at->diffForHumans() }}
                            </span>
                            
                            @if($notificacion->tipo)
                                <span class="notification-type-badge {{ $notificacion->tipo }}">
                                    {{ ucfirst($notificacion->tipo) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="notification-actions">
                        @if(!$notificacion->leida)
                            <button onclick="event.stopPropagation(); marcarLeida({{ $notificacion->id }})" 
                                    class="action-btn mark-read-btn"
                                    title="Marcar como leída">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z"/>
                                </svg>
                            </button>
                        @endif
                        
                        <button onclick="event.stopPropagation(); eliminarNotificacion({{ $notificacion->id }})" 
                                class="action-btn delete-btn"
                                title="Eliminar notificación">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.19 14,4.29 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"/>
                    </svg>
                </div>
                <h3 class="empty-title">No tienes notificaciones</h3>
                <p class="empty-description">Cuando recibas notificaciones aparecerán aquí</p>
            </div>
        @endforelse
    </div>
</div>

<style>
/* 🎨 Estilos para el Panel de Notificaciones */
.notifications-panel-container {
    max-width: 4xl;
    margin: 0 auto;
    padding: 1.5rem;
}

.notifications-panel-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.panel-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.875rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.panel-title-icon {
    width: 2rem;
    height: 2rem;
    color: #3b82f6;
}

.panel-stats {
    display: flex;
    gap: 1.5rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem 1rem;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    min-width: 4rem;
}

.stat-item.unread {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-color: #f59e0b;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.stat-item.unread .stat-number {
    color: #92400e;
}

.stat-label {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

.stat-item.unread .stat-label {
    color: #92400e;
}

.panel-actions {
    display: flex;
    gap: 1rem;
}

.mark-all-read-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
}

.mark-all-read-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(59, 130, 246, 0.4);
}

.btn-icon {
    width: 1rem;
    height: 1rem;
}

.notifications-filters {
    margin-bottom: 2rem;
}

.filter-tabs {
    display: flex;
    gap: 0.5rem;
    background: #f8fafc;
    padding: 0.5rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
}

.filter-tab {
    background: none;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-tab.active,
.filter-tab:hover {
    background: white;
    color: #1e293b;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notification-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.notification-card.unread {
    border-left: 4px solid #3b82f6;
    background: linear-gradient(90deg, #f0f9ff 0%, #ffffff 100%);
}

.notification-card-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
}

.notification-status-indicator {
    flex-shrink: 0;
    margin-top: 0.25rem;
}

.status-dot {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.unread-dot {
    background: #3b82f6;
    animation: notification-pulse 2s infinite;
}

.read-dot {
    background: #10b981;
}

.read-dot svg {
    width: 0.5rem;
    height: 0.5rem;
    color: white;
}

.notification-type-icon {
    flex-shrink: 0;
}

.type-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.type-icon svg {
    width: 1.25rem;
    height: 1.25rem;
}

.loan-icon {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #16a34a;
}

.payment-icon {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #2563eb;
}

.due-icon {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
    color: #ea580c;
}

.general-icon {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #64748b;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-message {
    font-size: 1rem;
    line-height: 1.5;
    color: #1e293b;
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.notification-card.read .notification-message {
    color: #64748b;
    font-weight: 400;
}

.notification-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.notification-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: #64748b;
}

.time-icon {
    width: 0.875rem;
    height: 0.875rem;
}

.notification-type-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.notification-type-badge.prestamo {
    background: #dcfce7;
    color: #16a34a;
}

.notification-type-badge.pago {
    background: #dbeafe;
    color: #2563eb;
}

.notification-type-badge.vencimiento {
    background: #fed7aa;
    color: #ea580c;
}

.notification-type-badge.general {
    background: #f1f5f9;
    color: #64748b;
}

.notification-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.action-btn {
    width: 2.5rem;
    height: 2.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn svg {
    width: 1rem;
    height: 1rem;
}

.mark-read-btn {
    background: #f0f9ff;
    color: #0369a1;
}

.mark-read-btn:hover {
    background: #0369a1;
    color: white;
    transform: scale(1.1);
}

.delete-btn {
    background: #fef2f2;
    color: #dc2626;
}

.delete-btn:hover {
    background: #dc2626;
    color: white;
    transform: scale(1.1);
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    width: 4rem;
    height: 4rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

.empty-icon svg {
    width: 100%;
    height: 100%;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #475569;
    margin: 0 0 0.5rem 0;
}

.empty-description {
    color: #64748b;
    margin: 0;
}

.notifications-pagination {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .notifications-panel-container {
        padding: 1rem;
    }
    
    .notifications-panel-header {
        padding: 1.5rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .panel-stats {
        justify-content: center;
    }
    
    .filter-tabs {
        flex-wrap: wrap;
    }
    
    .notification-card-content {
        padding: 1rem;
        gap: 0.75rem;
    }
    
    .notification-actions {
        flex-direction: column;
    }
}

@keyframes notification-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
/* 🎨 Colores actualizados para tipos específicos */

/* Notificaciones de MORA - Color ROJO */
.notification-card[data-tipo="mora"] {
    border-left: 4px solid #dc2626 !important;
    background: linear-gradient(90deg, #fef2f2 0%, #ffffff 100%) !important;
}

.notification-card[data-tipo="mora"] .notification-message {
    color: #991b1b !important;
}

.mora-icon {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%) !important;
    color: #dc2626 !important;
}

.notification-type-badge.mora {
    background: #fecaca !important;
    color: #991b1b !important;
    border: 1px solid #f87171;
}

/* Notificaciones de PAGO - Color VERDE */
.notification-card[data-tipo="pago"] {
    border-left: 4px solid #16a34a !important;
    background: linear-gradient(90deg, #f0fdf4 0%, #ffffff 100%) !important;
}

.notification-card[data-tipo="pago"] .notification-message {
    color: #15803d !important;
}

.payment-icon {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%) !important;
    color: #16a34a !important;
}

.notification-type-badge.pago {
    background: #dcfce7 !important;
    color: #15803d !important;
    border: 1px solid #86efac;
}

/* Mantener otros colores existentes */
.loan-icon {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #4f46e5;
}

.notification-type-badge.prestamo {
    background: #e0e7ff;
    color: #4338ca;
}

.due-icon {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
    color: #ea580c;
}

.notification-type-badge.vencimiento {
    background: #fed7aa;
    color: #ea580c;
}

.general-icon {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #64748b;
}

.notification-type-badge.general {
    background: #f1f5f9;
    color: #64748b;
}

/* Efectos hover para notificaciones de mora y pago */
.notification-card[data-tipo="mora"]:hover {
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.2) !important;
    border-left-color: #b91c1c !important;
}

.notification-card[data-tipo="pago"]:hover {
    box-shadow: 0 8px 25px rgba(22, 163, 74, 0.2) !important;
    border-left-color: #15803d !important;
}

/* Indicadores de estado para mora y pago */
.notification-card[data-tipo="mora"] .unread-dot {
    background: #dc2626 !important;
    box-shadow: 0 0 0 2px #fecaca;
}

.notification-card[data-tipo="pago"] .unread-dot {
    background: #16a34a !important;
    box-shadow: 0 0 0 2px #dcfce7;
}

/* Botones de acción con colores específicos */
.notification-card[data-tipo="mora"] .mark-read-btn {
    background: #fef2f2 !important;
    color: #dc2626 !important;
}

.notification-card[data-tipo="mora"] .mark-read-btn:hover {
    background: #dc2626 !important;
    color: white !important;
}

.notification-card[data-tipo="pago"] .mark-read-btn {
    background: #f0fdf4 !important;
    color: #16a34a !important;
}

.notification-card[data-tipo="pago"] .mark-read-btn:hover {
    background: #16a34a !important;
    color: white !important;
}
</style>

<script>
// JavaScript actualizado para incluir filtros por tipo
function filtrarNotificaciones(tipo) {
    // Actualizar tabs activos
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filtrar tarjetas
    const cards = document.querySelectorAll('.notification-card');
    cards.forEach(card => {
        const status = card.getAttribute('data-status');
        const tipoCard = card.getAttribute('data-tipo');
        let mostrar = false;
        
        switch(tipo) {
            case 'todas':
                mostrar = true;
                break;
            case 'no-leidas':
                mostrar = status === 'unread';
                break;
            case 'leidas':
                mostrar = status === 'read';
                break;
            case 'mora':
                mostrar = tipoCard === 'mora';
                break;
            case 'pago':
                mostrar = tipoCard === 'pago';
                break;
        }
        
        if (mostrar) {
            card.style.display = 'block';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                card.style.display = 'none';
            }, 200);
        }
    });
}

// Resto del JavaScript permanece igual...
function marcarLeida(id) {
    const card = document.querySelector(`[data-id="${id}"]`);
    
    fetch(`/admin/notificaciones/${id}/leida`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            card.classList.remove('unread');
            card.classList.add('read');
            card.setAttribute('data-status', 'read');
            
            const markBtn = card.querySelector('.mark-read-btn');
            if (markBtn) {
                markBtn.remove();
            }
            
            actualizarEstadisticas();
            mostrarNotificacion('Notificación marcada como leída', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al marcar la notificación', 'error');
    });
}

// ... resto de funciones JavaScript igual que antes
</script>
@endsection