<?php

namespace App\Http\Controllers;

use App\Models\Articulos;
use App\Models\ArticulosFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ArticulosController extends Controller
{
    //
    
    function __construct()
    {
        $this->middleware('permission:ver-articulos|crear-articulos|editar-articulos|borrar-articulos',['only'=>['index']]);
        $this->middleware('permission:crear-articulos', ['only'=>['create','store']]);
        $this->middleware('permission:editar-articulos', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-articulos', ['only'=>['destroy']]);
    }


    public function store(Request $request){

        $max_code = Articulos::select(
            DB::raw(' (IFNULL(MAX(RIGHT(articulos_codigo,7)),0)) AS number_max')
        )->first();

        $year = date('Y');
        $code = 'PRE'.$year.'-'.str_pad($max_code->number_max +1, 7, "0", STR_PAD_LEFT);

        $articles = Articulos::create([
            'articulos_codigo' => $code,
            'titulo' => $request->input('titulo'),
            'referencia' => $request->input('referencia'),
            'estado' => ($request->input('estado')?$request->input('estado'):0)
        ]);

        $file = $request->file('file');

        if($file){
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if($foo == 'pdf'){
                $route_file = $code.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                Storage::disk('public')->put($route_file,\File::get($file));
                ArticulosFile::create([
                    'articulos_id' => $articles->id,
                    'url' => $route_file,
                    'nombre' => $filename
                ]);
                return response()->json(['response' => [
                        'msg' => 'Registro Completado',
                        ]
                    ], 201);
            }else{
                return response()->json(['response' => [
                    'msg' => 'Solo Archivos PDF',
                    ]
                ], 201);
            }
        }

    }

    public function urlfile($articulos_id){
        $file = ArticulosFile::where('articulos_id',$articulos_id)->where('estado',1)->first();
        return response()->json(['response' => [
            'url' => $file->url,
            'nombre' => $file->nombre,
            ]
        ], 201);
    }

    public function update(Request $request){
        $id = $request->input('articulos_id');
        $code = $request->input('articulos_code');
        Articulos::where('id',$id)->update([
            'titulo' => $request->input('titulo'),
            'referencia' => $request->input('referencia'),
            'estado' => ($request->input('estado')?$request->input('estado'):0)
        ]);

        ArticulosFile::where('articulos_id',$id)->update(['estado'=>0]);

        $file = $request->file('file');
        if($file){
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if($foo == 'pdf'){
                $route_file = $code.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                Storage::disk('public')->put($route_file,\File::get($file));
                ArticulosFile::create([
                    'articulos_id' => $id,
                    'url' => $route_file,
                    'nombre' => $filename
                ]);
                return response()->json(['response' => [
                        'msg' => 'Se actualizo Correctamente',
                        ]
                    ], 201);
            }else{
                return response()->json(['response' => [
                    'msg' => 'Solo Archivos PDF',
                    ]
                ], 201);
            }
        }

    }

    public function destroy($id){
        Articulos::where('id',$id)->delete();
        return response()->json(['response' => [
            'msg' => 'Eliminado Correctamente',
            ]
        ], 201);
    }


}
