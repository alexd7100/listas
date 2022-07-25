@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Fichas Técnicas</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                            @can('crear-thesis')
                            <a type="button" href="{{ route('productos.create') }}" class="bg-gray-500 px-12 py-2 text-gray-200 font-semibold hover:bg-indigo-800 transition duration-200 each-in-out" data-toggle="modal" data-target="#exampleModal">Crear</a>
                            @endcan

                            <table id="theses" class="table table-striped table-hover" style="width: 100%;">
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
                                    @foreach ($theses as $key => $item)
                                    <tr class="text-center">
                                        <th style="display: none;" scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td style="display: none;">{{ $item->state }}</td>
                                        <div class="flex justify-center rounded-lg text-lg" role="group">
                                            <td width="40%">
                                                <button type="button" class="rounded bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4" onclick="showFile('{{ $item->id }}')">Ver</button>

                                                @can('editar-thesis')
                                                <button type="button" class="rounded bg-blue-400 hover:bg-gray-500 text-white font-bold py-2 px-4" onclick="modalEdit('{{ $item->id }}','{{ $item->title }}','{{ $item->reference }}','{{ $item->state }}','{{ $item->thesis_code }}')" data-toggle="modal" data-target="#exampleModalEdit">Editar</button>
                                                @endcan 
                                                
                                                @can('borrar-thesis')
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
    @method('PUT')
    @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Ficha Técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="reference">Referencia</label>
                    <input type="text" class="form-control" id="reference" name="reference">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Archivo</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" value="1" checked class="form-check-input" id="exampleCheck1" name="state">
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
                <h5 class="modal-title" id="exampleModalLabel">Editar Ficha Técnica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="title-edit" name="title">
                    <label for="title">Referencia</label>
                    <input type="text" class="form-control" id="reference-edit" name="reference">
                    <input type="hidden" id="thesis_id" name="thesis_id">
                    <input type="hidden" id="thesis_code" name="thesis_code">
                </div>
                <div class="form-group">
                    <label for="file-edit">Archivo</label>
                    <input type="file" class="form-control-file" id="file-edit" name="file">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" value="1" checked class="form-check-input" id="state-edit" name="state">
                    <label class="form-check-label" for="state-edit">Activo</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-update">Actualizar</button>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    function modalEdit(id, tit, ref, est, cod) {
        $('#title-edit').val(tit);
        $('#state-edit').val(est);
        $('#reference-edit').val(ref);
        $('#thesis_id').val(id);
        $('#thesis_code').val(cod);
    }
</script>

<script>
    $("#btn-register").click(function() {
        var formData = new FormData(document.getElementById("exampleModal"));
        $.ajax({
            url: "{{ route('thesis_register') }}",
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
            url: "{{ asset('/thesis/file/') }}/" + id,
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
            url: "{{ route('thesis_update') }}",
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
            url: "{{ asset('/thesis/delete/') }}/" + id,
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
        $('#theses').DataTable();
    });
</script>
@endsection