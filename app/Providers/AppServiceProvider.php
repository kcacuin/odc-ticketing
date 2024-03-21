<?php

namespace App\Providers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'ticket' => Ticket::class,
        ]);
        Relation::morphMap([
            'user' => 'App\Models\User',
            // Add other morphable models here if needed
        ]);
        Component::macro('notify', function ($message) {
            $this->dispatch('notify', $message);
        });

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        Schema::defaultStringLength(191);
    }
}
