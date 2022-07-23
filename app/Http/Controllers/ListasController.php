<?php

namespace App\Http\Controllers;

use App\Models\Listas;
use App\Models\ListasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ListasController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:ver-listas|crear-listas|editar-listas|borrar-listas',['only'=>['index']]);
        $this->middleware('permission:crear-listas', ['only'=>['create','store']]);
        $this->middleware('permission:editar-listas', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-listas', ['only'=>['destroy']]);
    }

    public function store(Request $request){

        $max_code = Listas::select(
            DB::raw(' (IFNULL(MAX(RIGHT(listas_code,7)),0)) AS number_max')
        )->first();

        $year = date('Y');
        $code = 'LE'.$year.'-'.str_pad($max_code->number_max +1, 7, "0", STR_PAD_LEFT);

        $listas = Listas::create([
            'listas_code' => $code,
            'title' => $request->input('title'),
            'reference' => $request->input('reference'),
            'state' => ($request->input('state')?$request->input('state'):0)
        ]);

        $file = $request->file('file');

        if($file){
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if($foo == 'pdf'){
                $route_file = $code.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                Storage::disk('public')->put($route_file,\File::get($file));
                ListasFile::create([
                    'listas_id' => $listas->id,
                    'url' => $route_file,
                    'name' => $filename
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

    public function urlfile($listas_id){
        $file = ListasFile::where('listas_id',$listas_id)->where('state',1)->first();
        return response()->json(['response' => [
            'url' => $file->url,
            'name' => $file->name,
            ]
        ], 201);
    }

    public function update(Request $request){
        $id = $request->input('listas_id');
        $code = $request->input('listas_code');
        Listas::where('id',$id)->update([
            'title' => $request->input('title'),
            'reference' => $request->input('reference'),
            'state' => ($request->input('state')?$request->input('state'):0)
        ]);

        ListasFile::where('listas_id',$id)->update(['state'=>0]);

        $file = $request->file('file');
        if($file){
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if($foo == 'pdf'){
                $route_file = $code.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                Storage::disk('public')->put($route_file,\File::get($file));
                ListasFile::create([
                    'listas_id' => $id,
                    'url' => $route_file,
                    'name' => $filename
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
        Listas::where('id',$id)->delete();
        return response()->json(['response' => [
            'msg' => 'Eliminado Correctamente',
            ]
        ], 201);
    }
}
