<?php

namespace Madewithlove\LaravelCqrsEs\Generators\Console;

class Event extends AbstractGeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'generate:event';

    /**
     * @var string
     */
    protected $description = 'Generate new event.';

    /**
     * @var string
     */
    protected $type = 'event';
}