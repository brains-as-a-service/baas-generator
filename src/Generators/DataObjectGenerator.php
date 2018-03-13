<?php

namespace Baas\Generator\Generators;

class DataObjectGenerator extends Generator
{
    /**
     * The name will created.
     *
     * @var string
     */
    protected $name;

    /**
     * The dataobject instance.
     *
     * @var \Baas\Generator\BaasDataObject
     */
    protected $baasdataobject;

    /**
     * The constructor.
     *
     * @param $name
     */
    public function __construct(
        $name
    ) {
        $this->name = $name;
    }

   
}
