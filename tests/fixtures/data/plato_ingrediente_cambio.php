<?php

    return [
	    ['id_plato' => 1, 'id_ingrediente' => 2, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 1, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 1, 'accion' => 2],// Quitar el 4
        ['id_plato' => 1, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 1],// Añadir el 1

        ['id_plato' => 2, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 2, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1],

        ['id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 3, 'id_ingrediente' => 5, 'orden_cambio' => 0, 'accion' => 1],
        ['id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 2],// Quitar el 1
        ['id_plato' => 3, 'id_ingrediente' => 2, 'orden_cambio' => 1, 'accion' => 1],// Añadir el 2
    ];
