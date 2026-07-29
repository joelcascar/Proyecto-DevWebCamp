<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Paquete;
use Model\Ponente;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistradosController
{
    public static function index(Router $router)
    {

        if (!isAdmin()) {
            header('location: /login');
        }
        // Definimos los valores para la paginación
        // obtener la página actual
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        // validamos que la pagina actual exista o no tenga valores negativos
        if (!$pagina_actual || $pagina_actual < 1) {
            header('location: /admin/registrados?page=1');
        }
        // Definir los registros a mostrar po pagina
        $registros_por_pagina = 10;
        // obtenemos el numero total de registros
        $total_registros = Registro::total();
        // Obtenemos el objeto de Paginación
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('location: /admin/registrados?page=1');
        }
        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());

        foreach ($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}
