<?php
namespace App\Models;

include("catalogo.php");
include("UsuarioDAO.php");

class catalogoDAO{
    private $objetoUsuarioDAO;
    private $conexion;

    public function __construct() {
        $this->objetoUsuarioDAO = new UsuarioDAO();
    }

    public function consultaCatalogo($tipo)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();
            $catalogo = array();

            // Crear la sentencia sql de busqueda
            $csql = "SELECT nombre, precio, imagen FROM productos WHERE coleccion = :tipo";

            $consulta = $this->conexion->prepare($csql);
            $consulta->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $catalogo = null;
            } else {
                foreach ($resultado as $fila) {
                    $producto = array(
                        "nombre" => $fila["nombre"],
                        "precio" => $fila["precio"],
                        "imagen" => $fila["imagen"]
                    );
                    array_push($catalogo, $producto);
                }
            }

            return json_encode($catalogo);
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }

    public function coleccion($sexo)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();
            $catalogo = array();

            // Crear la sentencia sql de busqueda
            $csql = "SELECT nombre, precio, imagen FROM productos WHERE genero = :sexo";

            $consulta = $this->conexion->prepare($csql);
            $consulta->bindValue(':sexo', $sexo, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $catalogo = null;
            } else {
                foreach ($resultado as $fila) {
                    $producto = array(
                        "nombre" => $fila["nombre"],
                        "precio" => $fila["precio"],
                        "imagen" => $fila["imagen"]
                    );
                    array_push($catalogo, $producto);
                }
            }

            return json_encode($catalogo);
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }
}
?>
