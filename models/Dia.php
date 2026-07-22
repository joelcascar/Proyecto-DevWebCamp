<?php

namespace Model;

class Dia extends ActiveRecord
{
    public static $tabla = 'dias';
    public static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;
}
