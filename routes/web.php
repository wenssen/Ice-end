<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PlanProduccionController;
use App\Http\Controllers\DashboardController;

/*
|----------------------------------------------------------------------
| Home
|----------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|----------------------------------------------------------------------
| Dashboard
|----------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

/*
|----------------------------------------------------------------------
| Perfil
|----------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|----------------------------------------------------------------------
| Materia Prima
|----------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/materias-primas', [MateriaPrimaController::class, 'index'])->name('materias-primas.index');
    Route::get('/alertas-stock', [MateriaPrimaController::class, 'alertas'])->name('alertas-stock');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/materias-primas/create', [MateriaPrimaController::class, 'create'])->name('materias-primas.create');
    Route::post('/materias-primas', [MateriaPrimaController::class, 'store'])->name('materias-primas.store');
    Route::get('/materias-primas/{id}/edit', [MateriaPrimaController::class, 'edit'])->name('materias-primas.edit');
    Route::put('/materias-primas/{id}', [MateriaPrimaController::class, 'update'])->name('materias-primas.update');
    Route::delete('/materias-primas/{id}', [MateriaPrimaController::class, 'destroy'])->name('materias-primas.destroy');
});

/*
|----------------------------------------------------------------------
| Proveedores
|----------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/{id}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{id}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
    Route::get('/proveedores/{id}', [ProveedorController::class, 'show'])->name('proveedores.show');
});

/*
|----------------------------------------------------------------------
| Compras
|----------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/compras/create', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');

    Route::get('/compras/{id}/edit', [CompraController::class, 'edit'])->name('compras.edit');
    Route::put('/compras/{id}', [CompraController::class, 'update'])->name('compras.update');
    Route::delete('/compras/{id}', [CompraController::class, 'destroy'])->name('compras.destroy');
});

/*
|----------------------------------------------------------------------
| Productos
|----------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

/*
|----------------------------------------------------------------------
| Recetas
|----------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin,cocina'])->group(function () {
    Route::get('/recetas', [RecetaController::class, 'index'])->name('recetas.index');
    Route::get('/recetas/create', [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');

    Route::get('/recetas/{idProducto}', [RecetaController::class, 'show'])->name('recetas.show');
    Route::get('/recetas/{idProducto}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('/recetas/{idProducto}', [RecetaController::class, 'update'])->name('recetas.update');
});

/*
|----------------------------------------------------------------------
| Producción
|----------------------------------------------------------------------
*/
// Admin: Crear, Editar, Eliminar
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/produccion/create', [PlanProduccionController::class, 'create'])->name('produccion.create');
    Route::post('/produccion', [PlanProduccionController::class, 'store'])->name('produccion.store');
    Route::get('/produccion/{plan}/edit', [PlanProduccionController::class, 'edit'])->name('produccion.edit');
    Route::put('/produccion/{plan}', [PlanProduccionController::class, 'update'])->name('produccion.update');
    Route::delete('/produccion/{plan}', [PlanProduccionController::class, 'destroy'])->name('produccion.destroy');
});

// Cocina: Solo ver los planes
Route::middleware(['auth', 'role:cocina'])->group(function () {
    Route::get('/produccion', [PlanProduccionController::class, 'index'])->name('produccion.index'); // Solo ver
    Route::get('/produccion/{plan}', [PlanProduccionController::class, 'show'])->name('produccion.show'); // Solo ver
});

// Admin y Cocina: Cambiar estado
Route::middleware(['auth', 'role:admin,cocina'])->group(function () {
    Route::patch('/produccion/{plan}/estado', [PlanProduccionController::class, 'cambiarEstado'])->name('produccion.estado');
    Route::get('/produccion', [PlanProduccionController::class, 'index'])->name('produccion.index');
});

/*
|----------------------------------------------------------------------
| Usuarios / Roles
|----------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

    Route::get('/usuarios/{user}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');

    Route::patch('/usuarios/{user}/toggle', [UsuarioController::class, 'toggleActive'])->name('usuarios.toggle');

    Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

/*
|----------------------------------------------------------------------
| Auth
|----------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
