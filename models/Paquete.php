<?php

namespace Model;

class Paquete extends ActiveRecord
{
    public static $tabla = 'paquetes';
    public static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}
