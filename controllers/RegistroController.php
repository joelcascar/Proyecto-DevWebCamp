<?php

namespace Controllers;

use Model\Paquete;
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

        // Verificar si el usuario esta registrado
        // $registro = Registro::where('usuario_id', $_SESSION['id']);
        // if (isset($registro) && $registro->paquete_id === '3') {
        //     header("location: /boleto?id=" . urlencode($registro->token));
        // }


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
}
