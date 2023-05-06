<?php

/* Crear un nuevo endpoint para hacer una consulta
donde con el id del usuario de la sesión del tipo
select correo from usuarios where id='x' AND user = 'x'
para crear el token y de respuesta de el token

$_SESSION['token'] = generarToken();
*/

use App\Models\CatalogoDAO;
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

// Endpoint para recuperar los productos de la tienda
Route::get('/api/catalogo/{tipo}', function ($tipo) {

    $catalogoDAO = new CatalogoDAO;
    $resultado = $catalogoDAO->consultaCatalogo($tipo);
    if (!$resultado) {
        return response()->json(['error' => 'No hay artículos'], 404);
    }
    return response()->json(["data"=>$resultado]);
});

// Endpoint para recuperar los productos según la colección hombre o mujer
Route::get('/api/coleccion/{sexo}', function ($sexo) {

    $catalogoDAO = new CatalogoDAO;
    $resultado = $catalogoDAO->coleccion($sexo);
    if (!$resultado) {
        return response()->json(['error' => 'No hay artículos'], 404);
    }
    return response()->json(["data"=>$resultado]);
});

// Endpoint para recuperar los productos según la colección hombre o mujer
Route::get('/api/producto/{id}', function ($id) {

    $catalogoDAO = new CatalogoDAO;
    $resultado = $catalogoDAO->producto($id);
    if (!$resultado) {
        return response()->json(['error' => 'No hay artículos'], 404);
    }
    return response()->json(["data"=>$resultado]);
});
