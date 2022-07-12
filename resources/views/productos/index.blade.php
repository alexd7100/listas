@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Productos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                            @can('crear-producto')
                            <a type="button" href="{{ route('productos.create') }}" class="bg-gray-500 px-12 py-2 text-gray-200 font-semibold hover:bg-indigo-800 transition duration-200 each-in-out">Crear</a>
                            @endcan

                            <table id="productos" class="table-fixed w-full" style="width: 100%;">
                                <thead>
                                    <tr class="bg-gray-800 text-white">
                                        <th style="display: none;">ID</th>
                                        <th class="border px-4 py-2">NOMBRE</th>
                                        <th class="border px-4 py-2">DESCRIPCION</th>
                                        <th class="border px-4 py-2">CATEGORIA</th>
                                        <th class="border px-4 py-2">IMAGEN</th>
                                        <th class="border px-4 py-2">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                    <tr>
                                        <td style="display: none;">{{$producto->id}}</td>
                                        <td>{{$producto->nombre}}</td>
                                        <td>{{$producto->descripcion}}</td>
                                        <td>{{$producto->categoria->nombre}}</td>
                                        <td class="border px-14 py-1">
                                            <img src="/imagen/{{$producto->imagen}}" width="60%">
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div class="flex justify-center rounded-lg text-lg" role="group">
                                                <!-- botón editar -->
                                                @can('editar-producto')
                                                <a href="{{ route('productos.edit', $producto->id) }}" class="rounded bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4">Editar</a>
                                                @endcan

                                                <!-- botón borrar -->
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="formEliminar">
                                                    @csrf
                                                    @method('DELETE')

                                                    @can('borrar-producto')
                                                    <button type="submit" class="rounded bg-blue-400 hover:bg-gray-500 text-white font-bold py-2 px-4">Borrar</button>
                                                    @endcan
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            <div>
                                {!! $productos->links() !!}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form  
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación del registro?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Eliminado!', 'El registro ha sido eliminado exitosamente.', 'success');
                        }
                    })
                }, false)
            })
    })()
</script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#productos').DataTable();
    });
</script>
@endsection