@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Listas de Precios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                            @can('crear-articulos')
                            <a type="button" href="{{ route('productos.create') }}" class="bg-gray-500 px-12 py-2 text-gray-200 font-semibold hover:bg-indigo-800 transition duration-200 each-in-out" data-toggle="modal" data-target="#exampleModal">Crear</a>
                            @endcan

                            <table id="articles" class="table table-striped table-hover" style="width: 100%;">
                                <thead>
                                    <tr class="bg-gray-800 text-white">
                                        <th style="display: none;">ID</th>
                                        <th class="border px-4 py-2">REFERENCIA</th>
                                        <th class="border px-4 py-2">DESCRIPCION</th>
                                        <th style="display: none;" class="border px-4 py-2">ESTADO</th>
                                        <th class="border px-4 py-2">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articulos as $key => $item)
                                    <tr class="text-center">
                                        <th style="display: none;" scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $item->referencia }}</td>
                                        <td>{{ $item->titulo }}</td>
                                        <td style="display: none;">{{ $item->estado }}</td>
                                        <div class="flex justify-center rounded-lg text-lg" role="group">
                                            <td width="40%">
                                                <button type="button" class="rounded bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4" onclick="showFile('{{ $item->id }}')">Ver</button>

                                                @can('editar-articulos')
                                                <button type="button" class="rounded bg-blue-400 hover:bg-gray-500 text-white font-bold py-2 px-4" onclick="modalEdit('{{ $item->id }}','{{ $item->titulo }}','{{ $item->referencia }}','{{ $item->estado }}','{{ $item->articulos_code }}')" data-toggle="modal" data-target="#exampleModalEdit">Editar</button>
                                                @endcan 
                                                
                                                @can('borrar-articulos')
                                                <button type="button" class="rounded bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4" onclick="deleteThesis('{{ $item->id }}')">Eliminar</button>
                                                @endcan

                                            </td>
                                        </div>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form enctype="multipart/form-data" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="titulo">Titulo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo">
                </div>
                <div class="form-group">
                    <label for="referencia">Referencia</label>
                    <input type="text" class="form-control" id="referencia" name="referencia">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Archivo</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" value="1" checked class="form-check-input" id="exampleCheck1" name="estado">
                    <label class="form-check-label" for="exampleCheck1">Activo</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-register">Guardar</button>
            </div>
        </div>
    </div>
</form>
<form enctype="multipart/form-data" class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Precio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="titulo-edit" name="titulo">
                    <label for="title">Referencia</label>
                    <input type="text" class="form-control" id="referencia-edit" name="referencia">
                    <input type="hidden" id="articulos_id" name="articulos_id">
                    <input type="hidden" id="articulos_codigo" name="articulos_codigo">
                </div>
                <div class="form-group">
                    <label for="file-edit">Archivo</label>
                    <input type="file" class="form-control-file" id="file-edit" name="file">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" value="1" checked class="form-check-input" id="estado-edit" name="estado">
                    <label class="form-check-label" for="estado-edit">Activo</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-update">Actualizar</button>
            </div>
        </div>
    </div>
</form>

<script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script>

<script>
    function modalEdit(id, tit, ref, est, cod) {
        $('#titulo-edit').val(tit);
        $('#estado-edit').val(est);
        $('#referencia-edit').val(ref);
        $('#articulos_id').val(id);
        $('#articulos_code').val(cod);
    }
</script>

<script>
    $("#btn-register").click(function() {
        var formData = new FormData(document.getElementById("exampleModal"));
        $.ajax({
            url: "{{ route('articulos_register') }}",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(res) {
            msg = JSON.parse(res).response.msg
            alert(msg);
            location.reload();
        }).fail(function(res) {
            console.log(res)
        });
    });

    function showFile(id) {
        $.ajax({
            url: "{{ asset('/articulos/file/') }}/" + id,
            type: "get",
            dataType: "html",
            contentType: false,
            processData: false
        }).done(function(res) {
            url = JSON.parse(res).response.url
            window.open('storage/' + url, '_blank');
        }).fail(function(res) {
            console.log(res)
        });
    }
    $("#btn-update").click(function() {
        var formData = new FormData(document.getElementById("exampleModalEdit"));
        $.ajax({
            url: "{{ route('articulos_update') }}",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(res) {
            msg = JSON.parse(res).response.msg
            alert(msg);
            location.reload();
        }).fail(function(res) {
            console.log(res)
        });
    });

    function deleteThesis(id) {
        $.ajax({
            url: "{{ asset('/articulos/delete/') }}/" + id,
            type: "get",
            dataType: "html",
            contentType: false,
            processData: false
        }).done(function(res) {
            msg = JSON.parse(res).response.msg
            alert(msg);
            location.reload();
        }).fail(function(res) {
            console.log(res)
        });
    }
</script>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#articles').DataTable();
    });
</script>
@endsection