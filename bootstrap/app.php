<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\sesionactiva;
use App\Http\Middleware\Validadpermisos;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        
    )

    ->withRouting(
        web: __DIR__.'/../routes/login.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/login.php'));

                //directorio de rutas carpeta Catalogo y sus sub carpetas
                $Path = base_path('routes/Catalogo');
                $PathRecursivoDirectorio = new RecursiveDirectoryIterator($Path);
                $PathRecursIvoterator = new RecursiveIteratorIterator($PathRecursivoDirectorio);
                foreach ($PathRecursIvoterator as $filename) {
                    if ($filename->isFile() && $filename->getExtension() === 'php') {
                        app()->router->middleware('api')->group($filename->getPathname());
                    }
                }
                $sistemasPath = base_path('routes/Sistemas');
                foreach (glob($sistemasPath . '/*.php') as $filename) {
                    app()->router->middleware('api')->group($filename);
                }
               
        }
    )


    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'sesionactiva' => \App\Http\Middleware\SesionActiva::class,
            'Validadpermisos' => \App\Http\Middleware\Validadpermisos::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
