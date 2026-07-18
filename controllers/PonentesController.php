<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager as Image;
use Model\Ponente;
use MVC\Router;

class PonentesController
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
            header('location: /admin/ponentes?page=1');
        }
        // Definir los registros a mostrar po pagina
        $registros_por_pagina = 10;
        // obtenemos el numero total de registros
        $total_registros = Ponente::total();
        // Obtenemos el objeto de Paginación
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if ($paginacion->total_paginas() < $pagina_actual) {
            header('location: /admin/ponentes?page=1');
        }
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router)
    {

        if (!isAdmin()) {
            header('location: /login');
        }
        $alertas = [];

        $ponente = new Ponente;
        $imagen_png = '';
        $imagen_webp = '';
        $imagen_avif = '';
        $carpeta_imagenes = '';
        $nombre_imagen = '';
        $redes = '';



        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!isAdmin()) {
                header('location: /login');
            }
            // Leer imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                // Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                // Creamos el manejador
                $manager = Image::usingDriver(GdDriver::class);

                // Generar imagen PNG
                $imagen_png = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::PNG, quality: 80);
                // Generar imagen WebP
                $imagen_webp = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::WEBP, quality: 80);
                // Generar imagen AVIF
                $imagen_avif = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::AVIF, quality: 80);

                // Creamos el nombre de la imagen
                $nombre_imagen = md5(uniqid(rand(), true));

                // Agregamos el nombre de la imagen al POST
                $_POST['imagen'] = $nombre_imagen;
            }

            // Convertimos un arreglo a string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            $redes = json_decode($ponente->redes);
            $alertas = $ponente->validar();

            // Guardamos el registro

            if (empty($alertas)) {

                if ($_FILES['imagen']['tmp_name']) {
                    // Guardar las imagenes
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                    $imagen_avif->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                }
                // Guardar el registro en la base de datos
                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function editar(Router $router)
    {
        if (!isAdmin()) {
            header('location: /login');
        }

        $alertas = [];
        $nombre_imagen = '';
        $carpeta_imagenes = '';


        // validar el id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('location: /admin/ponentes');
        };

        // Obtener ponente a editar
        $ponente = Ponente::find($id);

        if (!$ponente) {
            header('location:/admin/ponentes');
        };

        $ponente->imagen_actual = $ponente->imagen;


        $redes = json_decode($ponente->redes);

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!isAdmin()) {
                header('location: /login');
            }
            // Leer imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                // Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                // Creamos el manejador
                $manager = Image::usingDriver(GdDriver::class);

                // Generar imagen PNG
                $imagen_png = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::PNG, quality: 80);
                // Generar imagen WebP
                $imagen_webp = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::WEBP, quality: 80);
                // Generar imagen AVIF
                $imagen_avif = $manager->decode($_FILES['imagen']['tmp_name'])->cover(800, 800)->encodeUsingFormat(Format::AVIF, quality: 80);

                // Creamos el nombre de la imagen
                $nombre_imagen = md5(uniqid(rand(), true));

                // Agregamos el nombre de la imagen al POST
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }

            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            // sincronizamos los datos nuevo con el objeto actual
            $ponente->sincronizar($_POST);


            $alertas = $ponente->validar();


            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    if ($_FILES['imagen']['tmp_name']) {
                        // Eliminamos la imagen previa
                        $existeArchivo = file_exists($carpeta_imagenes . '/' . $ponente->imagen_actual . '.png');
                        if ($existeArchivo) {
                            unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . '.png');
                            unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . '.webp');
                            unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . '.avif');
                        }

                        // Guardar las imagenes
                        $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                        $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                        $imagen_avif->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');
                    }
                }
                $resultado = $ponente->guardar();

                if ($resultado) {
                    header('location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes

        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!isAdmin()) {
                header('location: /login');
            }
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                header('location: /admin/ponentes');
            }

            $ponente = Ponente::find($id);
            if (!isset($ponente)) {
                header('location: /admin/ponentes');
            }
            $carpeta_imagenes = '../public/img/speakers';

            $resultado = $ponente->eliminar();

            if ($resultado) {
                // Eliminamos la imagen
                $existeArchivo = file_exists($carpeta_imagenes . '/' . $ponente->imagen . '.png');
                if ($existeArchivo) {
                    unlink($carpeta_imagenes . '/' . $ponente->imagen . '.png');
                    unlink($carpeta_imagenes . '/' . $ponente->imagen . '.webp');
                    unlink($carpeta_imagenes . '/' . $ponente->imagen . '.avif');
                }
                header('location: /admin/ponentes');
            }
        }
    }
}
