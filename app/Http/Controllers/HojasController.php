<?php

namespace App\Http\Controllers;

use App\Models\Hojas;
use App\Models\HojasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HojasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-hojas|crear-hojas|editar-hojas|borrar-hojas',['only'=>['index']]);
        $this->middleware('permission:crear-hojas', ['only'=>['create','store']]);
        $this->middleware('permission:editar-hojas', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-hojas', ['only'=>['destroy']]);
    }

    public function store(Request $request){

        $max_code = Hojas::select(
            DB::raw(' (IFNULL(MAX(RIGHT(hojas_code,7)),0)) AS number_max')
        )->first();

        $year = date('Y');
        $code = 'HS'.$year.'-'.str_pad($max_code->number_max +1, 7, "0", STR_PAD_LEFT);

        $hojas = Hojas::create([
            'hojas_code' => $code,
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
                HojasFile::create([
                    'hojas_id' => $hojas->id,
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
    public function urlfile($hojas_id){
        $file = HojasFile::where('hojas_id',$hojas_id)->where('state',1)->first();
        return response()->json(['response' => [
            'url' => $file->url,
            'name' => $file->name,
            ]
        ], 201);
    }

    public function update(Request $request){
        $id = $request->input('hojas_id');
        $code = $request->input('hojas_code');
        Hojas::where('id',$id)->update([
            'title' => $request->input('title'),
            'reference' => $request->input('reference'),
            'state' => ($request->input('state')?$request->input('state'):0)
        ]);

        HojasFile::where('hojas_id',$id)->update(['state'=>0]);

        $file = $request->file('file');
        if($file){
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if($foo == 'pdf'){
                $route_file = $code.DIRECTORY_SEPARATOR.date('Ymdhmi').'.'.$foo;
                Storage::disk('public')->put($route_file,\File::get($file));
                HojasFile::create([
                    'hojas_id' => $id,
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
        Hojas::where('id',$id)->delete();
        return response()->json(['response' => [
            'msg' => 'Eliminado Correctamente',
            ]
        ], 201);
    }
}
