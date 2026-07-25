<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class PaginasController
{
    public static function index(Router $router)
    {

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

        // obtener el total de cada bloque
        $ponentesTotal = Ponente::total();
        $conferenciasTotal = Evento::total('categoria_id', 2);
        $workshopsTotal = Evento::total('categoria_id', 1);

        // Obtener todos los ponentes 
        $ponentes = Ponente::all();


        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'ponentesTotal' => $ponentesTotal,
            'conferenciasTotal' => $conferenciasTotal,
            'workshopsTotal' => $workshopsTotal,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router)
    {
        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre DevWebCamp'
        ]);
    }

    public static function paquetes(Router $router)
    {
        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes DevWebCamp'
        ]);
    }

    public static function conferencias(Router $router)
    {
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

        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }

    public static function error(Router $router)
    {
        $router->render('paginas/error', [
            'titulo' => 'Pagina no encontrada'
        ]);
    }
}
