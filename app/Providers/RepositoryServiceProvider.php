<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\BackofficePaymentRepository;
use App\Repositories\BackofficePaymentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BackofficePaymentRepositoryInterface::class, BackofficePaymentRepository::class);
    }
}
