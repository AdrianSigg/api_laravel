<?php

use Illuminate\Support\Facades\Route;
use App\Modelo\UsuarioDao;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/usuarios/{alias}/{contrasena}', function ($alias,$contrasena) {
    $usuarioDAO = new UsuarioDao();
    $usuario = $usuarioDAO->consulta($alias,$contrasena); // Método para obtener un usuario por alias y contraseña
    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }
    return response()->json(["usuario" => $usuario->getNombre(),"contraseña" => $usuario->getContrasena()]);
});


