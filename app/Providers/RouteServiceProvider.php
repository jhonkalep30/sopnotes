<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // LOAD ROUTES FROM MODULES
            Route::group([], function ($router) {
                foreach(self::listFolderFiles(base_path('routes/modules')) as $file){
                    if($file != '') require $file;
                }
            });

        });
    }

    public static function listFolderFiles($dir, $resultRemover = ''){
        try{
            foreach(scandir($dir) as $file){
                if ($file[0] == '.')
                    continue;
                if (is_dir("$dir/$file"))
                    foreach (self::listFolderFiles("$dir/$file") as $infile)
                        yield str_replace($resultRemover, '', $infile);
                else
                    yield str_replace($resultRemover, '', "${dir}/${file}");
            }
        }catch(\Exception $e){
            yield '';
        }
    }
    
}
