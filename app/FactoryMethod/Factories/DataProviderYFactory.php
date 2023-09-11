<?php

namespace App\FactoryMethod\Factories;

use App\FactoryMethod\DataProviderFactoryInterface;
use App\FactoryMethod\ProviderTypes\DataProviderY;

class DataProviderYFactory implements DataProviderFactoryInterface
{

    public function createProvider(): DataProviderY
    {
        return new DataProviderY();
    }
}
