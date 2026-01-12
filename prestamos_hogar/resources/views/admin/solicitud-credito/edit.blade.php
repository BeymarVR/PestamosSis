{{-- resources/views/admin/solicitud-credito/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Solicitud: {{ $solicitud->numero_solicitud }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.solicitud-credito.show', $solicitud->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.solicitud-credito.update', $solicitud->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Mismo formulario que create pero con valores -->
                        <!-- Nota: Por brevedad, solo muestro estructura. En la práctica, copiarías create.blade.php -->
                        <!-- y reemplazarías los inputs con value="{{ old('campo', $solicitud->campo) }}" -->
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Solo puede editar solicitudes en estado PENDIENTE.
                        </div>
                        
                        <!-- Aquí iría el mismo formulario extenso de create.blade.php -->
                        <!-- pero con los valores precargados de $solicitud -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Solicitud
                        </button>
                        <a href="{{ route('admin.solicitud-credito.show', $solicitud->id) }}" class="btn btn-default">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection