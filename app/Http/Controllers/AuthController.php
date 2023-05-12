<?php

namespace App\Http\Controllers;

use App\Models\UsuarioDao;

class AuthController extends Controller
{
    // ----- Iniciar Sesion
    public function login($username, $contrasena)
    {

        $usuarioDAO = new UsuarioDao();
        $usuario = $usuarioDAO->consulta($username, $contrasena); // Método para obtener un usuario por username y contraseña
        if (!$usuario) {
            return response()->json(['error' => 'Credenciales inválidas, intente nuevamente']);
        }

        // Verificar las credenciales del usuario aquí
        if ($usuario->getUsername() && $usuario->getContrasena()) {
            // Generar un token de sesión único para el usuario
            $token = md5(uniqid($username, true));

            $usuarioDAO->guardaToken($token,$username);

            // Devolver el token de sesión como parte de la respuesta JSON
            return response()->json(['token' => $token, 'user' => $username, 'mensaje' => 'Inició sesión correctamente']);
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }

    // ----- Obtener información del perfil
    function getPerfil($token)
    {
        $usuarioDAO = new UsuarioDao();
        $response = $usuarioDAO->perfil($token);
        if (!$response) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json([$response]);
    }

    // ----- Registrarse
    function signUp($username, $contrasena, $correo)
    {
        $usuarioDAO = new UsuarioDao();
        $usuario = $usuarioDAO->agrega($username, $contrasena, $correo);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(["response" => 'Usuario agregado correctamente']);
    }

    // ------ Cerrar Sesión
    function logout($token) {
        $usuarioDAO = new UsuarioDao();
        $usuarioDAO->borraToken($token);
        return response()->json(['data' => 'Sesión cerrada correctamente']);
    }

    function getToken($token){
        $usuarioDAO = new UsuarioDao();
        $resultado = $usuarioDAO->verificaSesion($token);

        if ($resultado) {
            return response()->json(['response' => 'Sesión activa']);
        } else {
            return response()->json(['response' => 'Sesión no activa']); // 401 indica que no se tiene autorización
        }
    }
}
