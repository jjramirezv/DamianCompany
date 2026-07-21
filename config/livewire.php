<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire handles file uploads by storing them in a temporary directory
    | before the final store method is called. Here you can configure
    | the directory, disk, and middleware for these uploads.
    |
    */

    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => 'file|max:12288',   // Máximo 12MB
        'directory' => 'livewire-tmp',
        'middleware' => 'web',         // Usamos solo el middleware web para evitar conflictos de firma
    ],

    /*
    |--------------------------------------------------------------------------
    | Manifest Path
    |--------------------------------------------------------------------------
    |
    | This path is used to store the Livewire manifest file.
    |
    */

    'manifest_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Back Button Support
    |--------------------------------------------------------------------------
    |
    | This enables support for the browser's back button.
    |
    */

    'back_button_support' => false,
];
