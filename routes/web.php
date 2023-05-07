<?php

/* Crear un nuevo endpoint para hacer una consulta
donde con el id del usuario de la sesión del tipo
select correo from usuarios where id='x' AND user = 'x'
para crear el token y de respuesta de el token

$_SESSION['token'] = generarToken();
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;

session_start(); // Iniciar sesión

Route::get('/', function () {
    return view('welcome');
});

// Endpoint para el inicio de sesion
Route::get('api/login/{username}/{contrasena}', [AuthController::class, 'login'])->name('login');

// Endpoint para el registro
Route::get('api/signup/{usuario}/{contrasena}/{correo}', [AuthController::class, 'signUp'])->name('signUp');

// Endpoint para consultar usuario
Route::get('api/profile/{token}', [AuthController::class, 'getPerfil'])->name('getPerfil');

// Endpoint para cerrar sesión
Route::get('api/logout/{token}', [AuthController::class, 'logout'])->name('logout');

// Endpoint para verificar sesión
Route::get('api/check/{token}', [AuthController::class, 'getToken'])->name('getToken');

// Endpoint para recuperar los productos de la tienda
Route::get('api/catalogo/{tipo}', [CatalogoController::class, 'getCatalogo'])->name('getCatalogo');

// Endpoint para recuperar los productos según la colección hombre o mujer
Route::get('api/coleccion/{sexo}', [CatalogoController::class, 'getProductos'])->name('getProductos');

// Endpoint para recuperar los productos según la colección hombre o mujer
Route::get('api/producto/{id}', [CatalogoController::class, 'getColeccion'])->name('getColeccion');
