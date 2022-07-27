@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Categorias</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                            @can('crear-categoria')
                            <a type="button" href="{{ route('categorias.create') }}" class="bg-gray-500 px-12 py-2 rounded text-gray-200 font-semibold hover:bg-indigo-800 transition duration-200 each-in-out">Crear</a>
                            @endcan

                            <table id="categorias" class="table-fixed w-full" style="width: 100%;">
                                <thead>
                                    <tr class="bg-gray-800 text-white">
                                        <th style="display: none;">ID</th>
                                        <th class="border px-4 py-2">CATEGORIA</th>
                                        <th class="border px-4 py-2">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                    <tr class="text-center">
                                        <td style="display: none;">{{$categoria->id}}</td>
                                        <td>{{$categoria->nombre}}</td>
                                        <td class="border px-4 py-2">
                                            <div class="flex justify-center rounded-lg text-lg" role="group">
                                                <!-- botón editar -->

                                                @can('editar-categoria')
                                                <a href="{{ route('categorias.edit', $categoria->id) }}" class="rounded bg-gray-500 hover:bg-gray-600 text-white font-semibold py-1 px-2">Editar</a>
                                                @endcan

                                                <!-- botón borrar -->
                                                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="formEliminar">
                                                    @csrf
                                                    @method('DELETE')

                                                    @can('borrar-categoria')
                                                    <button type="submit" class="rounded bg-blue-400 hover:bg-gray-500 text-white font-bold py-1 px-2">Borrar</button>
                                                    @endcan
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div>
                                {!! $categorias->links() !!}
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
        $('#categorias').DataTable();
    });
</script>
@endsection