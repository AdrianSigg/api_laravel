<?php

use Illuminate\Support\Facades\Route;
use App\Models\UsuarioDao;

session_start(); // Iniciar sesión

Route::get('/', function () {
    return view('welcome');
});

// Endpoint para el inicio de sesion
Route::get('/api/login/{username}/{contrasena}', function ($username,$contrasena) {
    $usuarioDAO = new UsuarioDao();
    $usuario = $usuarioDAO->consulta($username,$contrasena); // Método para obtener un usuario por username y contraseña
    if (!$usuario) {
        return response()->json(['error' => 'Credenciales inválidas, intente nuevamente']);
    }

    // Verificar las credenciales del usuario aquí
    if ($usuario->getUsername() && $usuario->getContrasena()) {
        // Generar un token de sesión único para el usuario
        $token = md5(uniqid($username, true));

        // Guardar el token de sesión en una variable de sesión
        $_SESSION['token'] = $token;

        // Devolver el token de sesión como parte de la respuesta JSON
        return response()->json(['token' => $token, 'user'=> $username, 'email'=> $username, 'mensaje' => 'Inició sesión correctamente']);
    } else {
        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }
});

// Endpoint para el verificar la sesión del usuario
Route::get('/api/verificar-sesion', function () {
    if (isset($_SESSION['token'])) {
        return response()->json(['token' => $_SESSION['token']]);
    } else {
        return response()->json(['error' => 'Sesión no encontrada'], 401);
    }
});


// Endpoint para el registro
Route::get('/api/signin/{usuario}/{contrasena}/{correo}', function ($username,$contrasena,$correo) {
    $usuarioDAO = new UsuarioDao();
    $usuario = $usuarioDAO->agrega($username,$contrasena,$correo); // Método para obtener un usuario por username y contraseña
    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }
    return response()->json(["response" => 'Usuario agregado correctamente']);
});

// Endpoint para cerrar sesión
Route::get('/api/logout', function () {
    session_destroy(); // Cierra sesión
    return response()->json(['response' => 'Sesión cerrada correctamente']);
});
