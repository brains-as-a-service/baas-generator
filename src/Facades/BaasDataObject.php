<?php

namespace Baas\Generator\Facades;

use Illuminate\Support\Facades\Facade;

class BaasDataObject extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'baasdataobject';
    }
}
