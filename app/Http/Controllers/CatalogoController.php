<?php

namespace App\Http\Controllers;
use App\Models\CatalogoDAO;

class CatalogoController extends Controller
{
    // ----- Recuperar catalogo
    function getCatalogo($tipo) {

        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->consultaCatalogo($tipo);
        if (!$resultado) {
            return response()->json(['error' => 'No hay artículos'], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Recuperar productos
    function getProductos($sexo) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->coleccion($sexo);
        if (!$resultado) {
            return response()->json(['error' => 'No hay artículos'], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Recuperar colección
    function getColeccion($id) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->producto($id);
        if (!$resultado) {
            return response()->json(['error' => 'No hay artículos'], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Guardar favoritos
    function favoritos($id_usuario, $id_producto) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->favoritos($id_usuario, $id_producto);
        if (!$resultado) {
            return response()->json(['error' => ''], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Recuperar favoritos
    function getFavoritos($id_usuario) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->getFavoritos($id_usuario);
        if (!$resultado) {
            return response()->json(['error' => 'error'], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Guardar Carrito
    function carrito($id_usuario, $id_producto) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->carrito($id_usuario, $id_producto);
        if (!$resultado) {
            return response()->json(['error' => ''], 404);
        }
        return response()->json(["data"=>$resultado]);
    }

    // ----- Recuperar Carrito
    function getCarrito($id_usuario) {
        $catalogoDAO = new CatalogoDAO;
        $resultado = $catalogoDAO->getCarrito($id_usuario);
        if (!$resultado) {
            return response()->json(['error' => 'error'], 404);
        }
        return response()->json(["data"=>$resultado]);
    }
}
