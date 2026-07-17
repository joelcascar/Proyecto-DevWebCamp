<?php

namespace Model;

class Ponente extends ActiveRecord
{
    public static $tabla = 'ponentes';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'redes'];

    public $id;
    public $nombre;
    public $apellido;
    public $ciudad;
    public $pais;
    public $imagen;
    public $tags;
    public $redes;
    // atributo temporal
    public $imagen_actual;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->ciudad = $args['ciudad'] ?? '';
        $this->pais = $args['pais'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->redes = $args['redes'] ?? '';
        $this->imagen_actual = $args['imagen_actual'] ?? '';
    }

    // Método para validar los ponentes
    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'ERROR: El Nombre es Obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'ERROR: El Apellido es Obligatorio';
        }
        if (!$this->ciudad) {
            self::$alertas['error'][] = 'ERROR: El Campo Ciudad es Obligatorio';
        }
        if (!$this->pais) {
            self::$alertas['error'][] = 'ERROR: El Campo País es Obligatorio';
        }
        if (!$this->imagen) {
            self::$alertas['error'][] = 'ERROR: La imagen es obligatoria';
        }
        if (!$this->tags) {
            self::$alertas['error'][] = 'ERROR: El Campo áreas es obligatorio';
        }

        return self::$alertas;
    }
}
