<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ArticuloFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-articulo|crear-articulo|editar-articulo|borrar-articulo', ['only' => ['index']]);
        $this->middleware('permission:crear-articulo', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-articulo', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-articulo', ['only' => ['destroy']]);
    }


    public function store(Request $request)
    {

        $max_code = Articulo::select(
            DB::raw(' (IFNULL(MAX(RIGHT(articulos_code,7)),0)) AS number_max')
        )->first();

        $year = date('Y');
        $code = 'DOC' . $year . '-' . str_pad($max_code->number_max + 1, 7, "0", STR_PAD_LEFT);

        $articles = Articulo::create([
            'articulos_code' => $code,
            'title' => $request->input('title'),
            'reference' => $request->input('reference'),
            'state' => ($request->input('state') ? $request->input('state') : 0)
        ]);

        
        $file = $request->file('file');

        if ($file) {
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if ($foo == 'pdf') {
                $route_file = $code . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
                Storage::disk('public')->put($route_file, \File::get($file));
                ArticuloFile::create([
                    'articulos_id' => $articles->id,
                    'url' => $route_file,
                    'name' => $filename
                ]);
                return response()->json([
                    'response' => [
                        'msg' => 'Registro Completado',
                    ]
                ], 201);
            } else {
                return response()->json([
                    'response' => [
                        'msg' => 'Solo Archivos PDF',
                    ]
                ], 201);
            }
        }
    }
    public function urlfile($articulos_id)
    {
        $file = ArticuloFile::where('articulos_id', $articulos_id)->where('state', 1)->first();
        return response()->json([
            'response' => [
                'url' => $file->url,
                'name' => $file->name,
            ]
        ], 201);
    }

    public function update(Request $request)
    {
        $id = $request->input('articulos_id');
        $code = $request->input('articulos_code');
        Articulo::where('id', $id)->update([
            'title' => $request->input('title'),
            'state' => ($request->input('state') ? $request->input('state') : 0)
        ]);

        ArticuloFile::where('articulos_id', $id)->update(['state' => 0]);

        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if ($foo == 'pdf') {
                $route_file = $code . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
                Storage::disk('prize')->put($route_file, \File::get($file));
                ArticuloFile::create([
                    'articulos_id' => $id,
                    'url' => $route_file,
                    'name' => $filename
                ]);
                return response()->json([
                    'response' => [
                        'msg' => 'Se actualizo Correctamente',
                    ]
                ], 201);
            } else {
                return response()->json([
                    'response' => [
                        'msg' => 'Solo Archivos PDF',
                    ]
                ], 201);
            }
        }
    }

    public function destroy($id)
    {
        Articulo::where('id', $id)->delete();
        return response()->json([
            'response' => [
                'msg' => 'Eliminado Correctamente',
            ]
        ], 201);
    }
}
