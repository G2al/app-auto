<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Temporary File Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Livewire handles file uploads by temporarily storing them before
    | the developer permanently stores them. These settings configure
    | the temporary storage location and validation rules.
    |
    */

    'temporary_file_upload' => [
        'disk' => 'local', // Uses storage/app/private (not publicly accessible)

        'rules' => [
            'required',
            'file',
            'max:10240', // 10MB max per file
            'mimes:jpeg,jpg,png,gif,webp,bmp,pdf',
        ],

        'directory' => 'livewire-tmp',

        'middleware' => [
            'throttle:60,1', // Max 60 upload requests per minute per IP
            'auth',          // Require authentication for file uploads
        ],

        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],

        'max_upload_time' => 5, // 5 minutes max for upload completion
        'cleanup' => true,
    ],

];
