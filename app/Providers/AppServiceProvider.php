<?php

namespace App\Providers;

use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('tasks_limit',
            function ($attributes, $value, $parameters, $validator) {
                $data = $validator->getData();

                $started_at = (new \DateTime($data['started_at']))->format('Y-m-d H:i:s');
                $ended_at = (new \DateTime($data['ended_at']))->format('Y-m-d H:i:s');

                $tasks = Task::where('started_at', '<=', $ended_at)->where('ended_at', '>=', $started_at)->count();
                return ($tasks < 4);
            },
            'По времени могут пересекаться не более 4х задач'
        );
    }
}
