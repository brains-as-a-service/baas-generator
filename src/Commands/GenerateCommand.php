<?php

namespace Baas\Generator\Commands;

use Illuminate\Console\Command;
use Baas\Generator\Exceptions\FileAlreadyExistException;
use Baas\Generator\Generators\FileGenerator;

abstract class GenerateCommand extends Command
{
    /**
     * The name of 'name' argument.
     *
     * @var string
     */
    protected $argumentName = '';

    /**
     * Get template contents.
     *
     * @return string
     */
    abstract protected function getTemplateContents();

    /**
     * Get the destination file path.
     *
     * @return string
     */
    abstract protected function getDestinationFilePath();

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());

        if (!$this->laravel['files']->isDirectory($dir = dirname($path))) {
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getTemplateContents();

        try {
            with(new FileGenerator($path, $contents))->generate();

            $this->info("Created : {$path}");
        } catch (FileAlreadyExistException $e) {
            $this->error("File : {$path} already exists.");
        }
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        return class_basename($this->argument($this->argumentName));
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        return '';
    }

    /**
     * Get class namespace.
     *
     * @param \Baas\Generator\BaasDataOject $baasdataobject
     *
     * @return string
     */
    public function getClassNamespace($baasdataobject)
    {
        $extra = str_replace($this->getClass(), '', $this->argument($this->argumentName));
        $extra = str_replace('/', '\\', $extra);
        $namespace = $this->laravel['baasgenerator']->config('namespace');
        $namespace .= '\\' . $this->getDefaultNamespace();
        $namespace .= '\\' . $extra;
        $namespace = str_replace('/', '\\', $namespace);
        return trim($namespace, '\\');
    }
}