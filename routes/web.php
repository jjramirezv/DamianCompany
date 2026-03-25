<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Tienda;
use App\Models\Producto; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/tienda', Tienda::class)->name('tienda');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/proyectos', function () {
    $proyectosDb = \App\Models\Proyecto::latest()->get();
    return view('proyectos', compact('proyectosDb'));
})->name('proyectos');

Route::get('/servicios', function () {
    $serviciosDb = \App\Models\Servicio::all();
    $clientesDb = \App\Models\Cliente::all(); 
    return view('servicios', compact('serviciosDb', 'clientesDb'));
})->name('servicios');

Route::get('producto/{id}', function ($id){
    $producto = Producto::with(['categoria', 'marca'])->findOrFail($id);
    return view('producto', compact('producto'));
})->name('producto.show');

// --- RUTAS DE MANTENIMIENTO (SÓLO PARA CONFIGURACIÓN) ---

Route::get('/limpiar-todo', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear'); // Agregamos esta para limpiar rutas
    return '¡Sistema purificado! La caché y las rutas se han borrado con éxito.';
});

Route::get('/instalar-bd', function () {
    // 1. Crea las tablas si no existen (sin borrar los datos que ya hay)
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    
    // 2. Ejecuta el Seeder para asegurar que el Admin siempre exista
    \Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'AdminSeeder', 
        '--force' => true
    ]);

    return '¡Magia pura! Base de datos actualizada y Admin Jelibeth asegurado.';
});

Route::get('/crear-admin', function () {
    $email = 'damiancompany@damiancompany.com.pe'; 
    if (\App\Models\User::where('email', $email)->exists()) {
        return 'El administrador ya existe.';
    }
    \App\Models\User::create([
        'name' => 'Admin Jelibeth',
        'email' => $email,
        'password' => Hash::make('admin12345'),
    ]);
    return '¡Usuario Administrador creado con éxito!';
});

Route::get('/test-env', function () {
    return [
        'CLOUDINARY_URL' => env('CLOUDINARY_URL') ? 'Configurado ✅' : 'VACÍO ❌',
        'FILESYSTEM_DISK' => config('filesystems.default'),
        'CLOUD_NAME' => config('cloudinary.cloud_url') ? 'Leído ✅' : 'No leído ❌',
    ];
});