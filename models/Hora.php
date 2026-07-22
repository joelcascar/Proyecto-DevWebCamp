<?php

namespace Model;

class Hora extends ActiveRecord
{
    public static $tabla = 'horas';
    public static $columnasDB = ['id', 'hora'];

    public $id;
    public $hora;
}
