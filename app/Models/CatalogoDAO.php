<?php

namespace App\Models;

include("catalogo.php");
include("UsuarioDAO.php");

class catalogoDAO
{
    private $objetoUsuarioDAO;
    private $conexion;

    public function __construct()
    {
        $this->objetoUsuarioDAO = new UsuarioDAO();
    }

    public function consultaCatalogo($tipo)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();
            $catalogo = array();

            // Crear la sentencia sql de busqueda
            $csql = "SELECT id, nombre, precio, imagen FROM productos WHERE coleccion = :tipo";

            $consulta = $this->conexion->prepare($csql);
            $consulta->bindValue(':tipo', $tipo, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $catalogo = null;
            } else {
                foreach ($resultado as $fila) {
                    $producto = array(
                        "id" => $fila["id"],
                        "nombre" => $fila["nombre"],
                        "precio" => $fila["precio"],
                        "imagen" => $fila["imagen"],
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
            $csql = "SELECT id, nombre, precio, imagen FROM productos WHERE genero = :sexo";

            $consulta = $this->conexion->prepare($csql);
            $consulta->bindValue(':sexo', $sexo, \PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $catalogo = null;
            } else {
                foreach ($resultado as $fila) {
                    $producto = array(
                        "id" => $fila["id"],
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

    public function producto($id)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();
            $catalogo = array();

            // Crear la sentencia sql de busqueda
            $csql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, e.cantidad, e.talla, dp.color
                    FROM productos p
                    JOIN existencia e ON p.id = e.id_producto
                    JOIN detalle_productos dp ON p.id = dp.id_producto
                    WHERE p.id = $id";

            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $catalogo = null;
            } else {
                foreach ($resultado as $fila) {
                    $producto = array(
                        "id" => $fila["id"],
                        "nombre" => $fila["nombre"],
                        "precio" => $fila["precio"],
                        "imagen" => $fila["imagen"],
                        "descripcion" => $fila["descripcion"],
                        "cantidad" => $fila["cantidad"],
                        "talla" => $fila["talla"],
                        "color" => $fila["color"],
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

    public function favoritos($id_usuario, $id_producto)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();

            // Verificar si el id_producto ya está presente en la lista de favoritos del usuario
            $csql = "SELECT id_productos FROM favoritos WHERE id_usuario = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

            if ($resultado !== false) {
                $id_productos = explode(",", $resultado["id_productos"]);
                if (in_array($id_producto, $id_productos)) {
                    return json_encode(["mensaje" => "El producto ya está en la lista de favoritos"]);
                }
            }

            // Agregar el id_producto a la lista de favoritos
            $csql = "UPDATE favoritos SET id_productos = IFNULL(CONCAT(id_productos, ', $id_producto'), '$id_producto') WHERE id_usuario = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();

            return json_encode(["mensaje" => "Producto agregado a favoritos"]);
        } catch (\PDOException $e) {
            // Manejar la excepción
            throw new \Exception("Error al agregar a favoritos: " . $e->getMessage());
        }
    }

    public function getFavoritos($id_usuario)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();

            // Agregar el id_producto a la lista de favoritos
            $csql = "SELECT id_productos FROM favoritos WHERE id_usuario = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();

            // Guardar los resultados en una variable
            $resultado = $consulta->fetchAll(\PDO::FETCH_COLUMN);

            return json_encode($resultado);
        } catch (\PDOException $e) {
            // Manejar la excepción
            throw new \Exception("Error al obtener favoritos: " . $e->getMessage());
        }
    }

    public function carrito($id_usuario, $id_producto)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();

            // Verificar si el id_producto ya está presente en la lista de carrito del usuario
            $csql = "SELECT id_carrito FROM carrito WHERE id = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();
            $resultado = $consulta->fetch(\PDO::FETCH_ASSOC);

            if ($resultado !== false) {
                $id_carrito = explode(",", $resultado["id_carrito"]);
                if (in_array($id_producto, $id_carrito)) {
                    return json_encode(["mensaje" => "El producto ya está en la lista de carrito"]);
                }
            }

            // Agregar el id_producto a la lista de carrito
            $csql = "UPDATE carrito SET id_carrito = IFNULL(CONCAT(id_carrito, ', $id_producto'), '$id_producto') WHERE id = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();

            return json_encode(["mensaje" => "Producto agregado a carrito"]);
        } catch (\PDOException $e) {
            // Manejar la excepción
            throw new \Exception("Error al agregar a carrito: " . $e->getMessage());
        }
    }

    public function getCarrito($id_usuario)
    {
        try {
            $this->conexion = $this->objetoUsuarioDAO->conecta();

            // Agregar el id_producto a la lista de Carrito
            $csql = "SELECT id_carrito FROM carrito WHERE id = '$id_usuario'";
            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();

            // Guardar los resultados en una variable
            $resultado = $consulta->fetchAll(\PDO::FETCH_COLUMN);

            return json_encode($resultado);
        } catch (\PDOException $e) {
            // Manejar la excepción
            throw new \Exception("Error al obtener Carrito: " . $e->getMessage());
        }
    }
}
