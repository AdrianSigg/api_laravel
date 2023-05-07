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
}
