<?php

namespace Roshandelpoor\Deploy;

use Illuminate\Support\Facades\Facade;

class DeployFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Deploy';
    }
}
