<?php

namespace Madewithlove\LaravelCqrsEs\Serializers;

use Broadway\Serializer\SerializerInterface;
use Broadway\Serializer\SimpleInterfaceSerializer;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SerializerInterface::class, function () {
            return new SimpleInterfaceSerializer();
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            SerializerInterface::class,
        ];
    }
}
