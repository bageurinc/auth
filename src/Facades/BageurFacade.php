<?php
namespace Bageur\Auth\Facades;
use Illuminate\Support\Facades\Facade;

class BageurFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'bageur';
    }

}
