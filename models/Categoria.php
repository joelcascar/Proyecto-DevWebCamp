<?php

namespace Model;

class Categoria extends ActiveRecord
{
    public static $tabla = 'categorias';
    public static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    // public function __construct(int $id, string $nombre)
    // {
    //     $this->id = $id ?? null;
    //     $this->nombre = $nombre ?? '';
    // }
}
