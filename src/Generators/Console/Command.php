<?php

namespace Madewithlove\LaravelCqrsEs\Generators\Console;

class Command extends AbstractGeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'generate:command';

    /**
     * @var string
     */
    protected $description = 'Generate new command, command handler and command handler test case';

    /**
     * @var string
     */
    protected $type = 'command';

    /**
     *
     */
    public function fire()
    {
        $this->callCommand();

        $this->info('All Done!');
    }

    /**
     *
     */
    private function callCommand()
    {
        $this->callCommandFile('command');
    }
}