<?php

namespace Model;

class EventoHorario extends ActiveRecord
{
    public static $tabla = 'eventos';
    public static $columnasDB = ['id', 'categoria_id', 'dia_id', 'hora_id'];

    public $id;
    public $categoria_id;
    public $dia_id;
    public $hora_id;
}
