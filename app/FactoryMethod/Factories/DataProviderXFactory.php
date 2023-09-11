<?php

namespace App\FactoryMethod\Factories;

use App\FactoryMethod\DataProviderFactoryInterface;
use App\FactoryMethod\ProviderTypes\DataProviderX;

class DataProviderXFactory implements DataProviderFactoryInterface
{

    public function createProvider(): DataProviderX
    {
        return new DataProviderX();
    }
}
