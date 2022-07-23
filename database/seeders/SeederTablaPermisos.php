<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permisos = [
            //Roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            //Usuarios
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',
            //Productos
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'borrar-producto',
            //Categorias
            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'borrar-categoria',
            //Fichas
            'ver-thesis',
            'crear-thesis',
            'editar-thesis',
            'borrar-thesis',
            //Articulos
            'ver-articulos',
            'crear-articulos',
            'editar-articulos',
            'borrar-articulos',
            //Listas Nacionales
            /* 'ver-listasn',
            'crear-listasn',
            'editar-listasn',
            'borrar-listasn',
            //Listas Exterior
            'ver-listase',
            'crear-listase',
            'editar-listase',
            'borrar-listase',
            //Hojas Seguridad
            'ver-hojas',
            'crear-hojas',
            'editar-hojas',
            'borrar-hojas', */
        ];
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
