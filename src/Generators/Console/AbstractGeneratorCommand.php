<?php

namespace Madewithlove\LaravelCqrsEs\Generators\Console;

use Illuminate\Config\Repository;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractGeneratorCommand extends GeneratorCommand
{
    use AppNamespaceDetectorTrait;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param Filesystem $files
     * @param Composer $composer
     * @param Repository $config
     */
    public function __construct(Filesystem $files, Composer $composer, Repository $config)
    {
        parent::__construct($files);

        $this->config = $config;
        $this->composer = $composer;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function parseName($name)
    {
        return $this->getNamespaceForType($this->option('type')).'\\'.$name;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $type = $this->option('type');

        $replacements = [
            '{{namespace}}' => $this->getNamespaceForType($type),
            '{{class}}' => $this->getNameInput(),
        ];

        switch ($type) {
            case 'commandHandler':
                $replacements['{{command}}'] = $this->getNamespaceForType('command').'\\'.$this->getNameInput();
                break;
        }

        foreach ($replacements as $placeholder => $replacement) {
            $stub = str_replace($placeholder, $replacement, $stub);
        }

        return $stub;
    }

    /**
     * @return mixed
     */
    protected function getStub()
    {
        return $this->config->get('broadway.generators.stubs.'.$this->option('type'));
    }

    /**
     * @return string
     */
    protected function getAggregateName()
    {
        return str_plural($this->option('aggregate'));
    }

    /**
     * @param $type
     *
     * @return string
     */
    protected function getNamespaceForType($type)
    {
        $type = ucfirst(str_plural($type));
        $rootNamespace = $this->getAppNamespace();
        $aggregateName = $this->getAggregateName();

        return $rootNamespace . implode('\\', [$aggregateName, $type]);
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['aggregate', null, InputOption::VALUE_REQUIRED, 'The aggregate the class belongs to'],
            ['type', null, InputOption::VALUE_OPTIONAL, 'The type of class to generate', $this->type],
        ];
    }


    /**
     * @param $type
     * @param $name
     * @param array $options
     */
    protected function callCommandFile($type, $name = null, $options = [])
    {
        $this->call('generate:file', array_merge($options, [
            'name'    => $name ?: $this->getNameInput(),
            '--type'  => $type,
            '--aggregate' => $this->option('aggregate'),
        ]));
    }
}