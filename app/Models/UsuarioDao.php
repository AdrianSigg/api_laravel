<?php

namespace App\Models;

use \pdo;

include("usuario.php");
class UsuarioDao
{

    // Parámetros de la conexión a la bd

    private $dsn = 'mysql:host=localhost;dbname=vesta;charset=utf8';
    private $usr = "root";
    private $pass = "";
    private $conexion;

    // ------Función de conectar

    public function conecta()
    {
        $conexion = new pdo(
            $this->dsn,
            $this->usr,
            $this->pass
        );
        $this->conexion = $conexion;
        return $conexion;
    }

    // ----- Función de consultar usuario
    public function consulta($alias, $contrasena)
    {
        try {
            $usuario = new Usuario();
            $this->conexion = $this->conecta();

            // Crear la sentencia sql de busqueda
            $csql = "select * from usuarios where usuario = '$alias' and contrasena = '$contrasena'";

            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $usuario = null;
            } else {
                foreach ($resultado as $fila) {
                        $usuario->setId($fila["id"]);
                        $usuario->setUsername($fila["usuario"]);
                        $usuario->setContrasena($fila["contrasena"]);
                }
            }

            return $usuario;
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }


    // ----- Funcion para consultar perfil
    public function perfil($token)
    {
        try {
            $this->conexion = $this->conecta();
            $perfil = array();

            // Crear la sentencia sql de busqueda
            $csql = "select * from usuarios where token = '$token'";

            $consulta = $this->conexion->prepare($csql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                $perfil = null;
            } else {
                foreach ($resultado as $fila) {
                    $info = array(
                        "nombre" => $fila["usuario"],
                        "correo" => $fila["correo"]
                    );
                    array_push($perfil, $info);
                }
            }

            return json_encode($perfil);
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }

    // ----- Funcion para guardar el token
    function guardaToken($token, $username)
    {
        try {
            $this->conexion = $this->conecta();

            // Crear la sentencia sql de busqueda
            // Crear la sentencia sql de busqueda
            $csql = "UPDATE usuarios SET token = :token WHERE usuario = :username";
            $consulta = $this->conexion->prepare($csql);
            $consulta->bindParam(':token', $token);
            $consulta->bindParam(':username', $username);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            return $resultado;
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }

    function borraToken($token)
    {
        try {
            $this->conexion = $this->conecta();

            // Crear la sentencia sql de busqueda
            // Crear la sentencia sql de busqueda
            $csql = "UPDATE usuarios SET token = NULL WHERE token = :token";
            $consulta = $this->conexion->prepare($csql);
            $consulta->bindParam(':token', $token);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            return $resultado;
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }

    // ----- Funcion para guardar el token
    function verificaSesion($token)
    {
        try {
            $this->conexion = $this->conecta();

            // Crear la sentencia sql de busqueda
            $csql = "SELECT usuario FROM usuarios WHERE token = :token";
            $consulta = $this->conexion->prepare($csql);
            $consulta->bindParam(':token', $token);
            $consulta->execute();
            $resultado = $consulta->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                return false;
            } else {
                return true;
            }
        } catch (\PDOException $e) {
            // Manejar la excepción
            return null;
        }
    }

    // ----- Función para eliminar usuario
    public function elimina($id)
    {

        $this->conecta();

        // Crear la sentencia sql de busqueda
        $csql = "delete from usuario
                    where id = " . $id;
        // elimina usuario
        //echo $csql;
        $this->conexion->query($csql);
    }

    public function agrega($alias, $contrasena, $correo)
    {
        $this->conecta();

        $csql = "insert into usuarios ( "
            . "usuario, contrasena, correo ) "
            . "values ( '{$alias}',
                    '{$contrasena}' ,
                    '{$correo}')";
        // echo $csql;
        $resultado = $this->conexion->query($csql);
        return $resultado;
    }

    public function actualiza($usuario)
    {

        $this->conecta();

        $csql = "UPDATE usuario SET nombre = '{$usuario->getUsername()}',
                 contrasena = '{$usuario->getContrasena()}', alias = '{$usuario->getAlias()}'
                 WHERE id = {$usuario->getId()}";

        $resultado = $this->conexion->query($csql);
        return $resultado;
    }
}
