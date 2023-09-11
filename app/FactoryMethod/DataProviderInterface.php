<?php

namespace App\FactoryMethod;

interface DataProviderInterface
{
    public function loadData(): array;

    public function setStatuses(): void;

    public function getStatusName($status): string;
}
