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

    private function conecta()
    {
        $conexion = new pdo(
            $this->dsn,
            $this->usr,
            $this->pass
        );
        $this->conexion = $conexion;
        return;
    }
    // -----Función de consultar

    public function consulta($alias, $contrasena)
    {

        $usuario = new Usuario();

        $this->conecta();

        // Crear la sentencia sql de busqueda
        $csql = "select * from usuarios
                    where usuario = '{$alias}'
                    and contrasena = '{$contrasena}' ";

        $resultado = $this->conexion->query($csql);

        if ($resultado->rowCount() == 0) {
            $usuario = null;
        } else {
            $fila = $resultado->fetch();
            $usuario = new Usuario();
            $usuario->setId($fila["id"]);
            $usuario->setUsername($fila["usuario"]);
            $usuario->setContrasena($fila["contrasena"]);
        }

        return $usuario;
    }
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

    public function lee($id)
    {
        $usuario = new Usuario();
        $this->conecta();

        // Crear la sentencia SQL de búsqueda
        $csql = "SELECT * FROM usuario WHERE id = {$id}";

        $resultado = $this->conexion->query($csql);

        if ($resultado->rowCount() == 0) {
            $usuario = null;
        } else {
            $fila = $resultado->fetch(PDO::FETCH_ASSOC);
            $usuario->setId($fila["id"]);
            $usuario->setUsername($fila["nombre"]);
            $usuario->setContrasena($fila["contrasena"]);
        }

        return $usuario;
    }
}
