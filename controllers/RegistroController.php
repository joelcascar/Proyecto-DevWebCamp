<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
use Model\Regalo;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController
{
    public static function crear(Router $router)
    {
        // Validaciones para evitar que el usuario se vuelva a registrar en el mismo plan
        if (!isAuth()) {
            header('location: /login');
        }

        //Verificar si el usuario esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if (isset($registro) && $registro->paquete_id === '3') {
            header("location: /boleto?id=" . urlencode($registro->token));
        }


        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!isAuth()) {
                header('location: /login');
            }
            // Verificar si el usuario esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (isset($registro) && $registro->paquete_id === '3') {
                header("location: /boleto?id=" . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            // Crear registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) {
                header("location: /boleto?id=" . urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router)
    {
        if (!isAuth()) {
            header('location: /login');
        }

        // validamos la URL
        $id = $_GET['id'];
        if (!$id || strlen($id) !== 8) {
            header('location: /');
        }

        // buscar en la base de datos
        $registro = Registro::where('token', $id);
        if (!$registro) {
            header('location: /');
        }

        // llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);


        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function pagar()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!isAuth()) {
                header('location: /login');
            }

            // Verificar si el usuario esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if (isset($registro) && $registro->paquete_id === '1') {
                header("location: /boleto?id=" . urlencode($registro->token));
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            $pago_id = substr(md5(uniqid(rand(), true)), 0, 17);

            // Crear registro
            $datos = array(
                'paquete_id' => 1,
                'pago_id' => $pago_id,
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            // verificar que post no venga vacio
            // if (empty($_POST)) {
            //     echo json_encode([]);
            //     return;
            // }

            // // Crear el registro

            // $datos = $_POST;
            // $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            // $datos['usuario_id'] = $_SESSION['id'];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) {
                header('location: /finalizar-registro/conferencias');
            }
        }
    }

    public static function conferencias(Router $router)
    {
        if (!isAuth()) {
            header('location: /login');
        }

        // Validar que el usuario tenga el plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);




        if ($registro->paquete_id !== '1') {
            header('location: /');
        }

        // Obtener los eventos ordenados por hora
        $eventos = Evento::ordenar('hora_id', 'ASC');

        // cruzamos la información para agregarlo a cada evento.
        foreach ($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }

        // creamos un nuevo arreglo para filtrar los eventos por dia y categoria
        $eventos_formateados = [];
        foreach ($eventos as $evento) {
            // Evaluamos que los eventos sean del dia viernes y conferencias
            if ($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }
            // Evaluamos que los eventos sean del dia sabado y conferencias
            if ($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }
            // Evaluamos que los eventos sean del dia viernes y workshops
            if ($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }
            // Evaluamos que los eventos sean del dia sabado y workshops
            if ($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        // Pasar Regalos hacia la vista
        $regalos = Regalo::all('ASC');

        // Manejaremos el registro mediante $_POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debuguear($_POST);
        }


        $router->render('registro/conferencias', [
            'titulo' => 'Elige workshops y conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }
}
