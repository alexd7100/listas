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
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <table  id="transit" class="table-fixed w-full">
                                <thead>
                                    <tr class="bg-gray-800 text-white">
                                        <th class="border px-4 py-2">LINEA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">SELLOS MECANICOS</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">FEL-TEMP Y FIELTRO SILICE</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">CORDONES TRENZADOS</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">HERRAMIENTAS</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">PRODUCTOS ESPECIALES</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">AISLAMIENTO TÉRMICO</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">ASIENTOS ESTACIONARIOS Y PISTAS - AEP</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">SELLADO ESTÁTICO - SE</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">ADHESIVOS</a>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400">
                                        <td class="border px-4 py-2">
                                            <a href="/articulos">PROTECTORES DE BRIDA - PB</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#transit').DataTable();
    });
</script>
@endsection