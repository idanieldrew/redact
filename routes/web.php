<?php

\Illuminate\Support\Facades\Route::get('/',function (){
    dd(
        env('DB_CONNECTION'),
        env('DB_HOST'),
        env('DB_PORT'),
        env('DB_DATABASE')
    );
});


