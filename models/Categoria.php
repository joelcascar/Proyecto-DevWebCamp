<?php

namespace Model;

class Categoria extends ActiveRecord
{
    public static $tabla = 'categorias';
    public static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}
