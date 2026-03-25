<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Tienda;
use App\Models\Producto; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tienda', Tienda::class)->name('tienda');

Route::get('producto/{id}', function ($id){
    $producto=Producto::with(['categoria', 'marca'])->findOrFail($id);
    return view('producto', compact('producto'));
})->name('producto.show');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/servicios', function () {
    $serviciosDb = \App\Models\Servicio::all();
    $clientesDb = \App\Models\Cliente::all(); 
    return view('servicios', compact('serviciosDb', 'clientesDb'));
})->name('servicios');

Route::get('/proyectos', function () {
    $proyectosDb = \App\Models\Proyecto::latest()->get();
    return view('proyectos', compact('proyectosDb'));
})->name('proyectos');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/instalar-bd', function () {
    Artisan::call('migrate', ['--force' => true]);
    return '¡Magia pura! Las tablas de Damian Company se crearon con éxito en la nube.';
});

Route::get('/crear-admin', function () {
    if (\App\Models\User::where('email', 'admin@damiancompany.com')->exists()) {
        return 'El administrador ya existe. Ve a /admin para iniciar sesión.';
    }

    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'damiancompany@damiancompany.com.pe',
        'password' => \Illuminate\Support\Facades\Hash::make('admin12345'),
    ]);

    return '¡Usuario Administrador creado con éxito! Ya puedes entrar a tu panel.';
});