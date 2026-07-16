<?php

namespace Controllers;

use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Format;
use Model\Ponente;
use MVC\Router;

class PonentesController
{
    public static function index(Router $router)
    {
        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas'
        ]);
    }
    public static function crear(Router $router)
    {

        $alertas = [];

        $ponente = new Ponente;

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
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
            $alertas = $ponente->validar();

            // Guardamos el registro

            if (empty($alertas)) {
                // Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                $imagen_avif->save($carpeta_imagenes . '/' . $nombre_imagen . '.avif');

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
            'ponente' => $ponente
        ]);
    }
}
