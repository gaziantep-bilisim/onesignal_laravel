<?php


namespace HumblDump\GBSignal;

use Illuminate\Support\Facades\Facade;


Class GBSignalFacade extends Facade
{
    /**
     * The getFacadeAccessor() function returns the name of the class that you want to use as a facade.
     *
     * @return The name of the binding in the service container.
     */
    protected static function getFacadeAccessor()
    {
        return 'GBSignal';
    }
}