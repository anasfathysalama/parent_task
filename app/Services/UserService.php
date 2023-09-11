<?php

namespace App\Services;

class UserService
{
    private array $providers;

    private string $providersNamespace;

    public function __construct()
    {
        $this->setProviders();
        $this->providersNamespace = "\App\FactoryMethod\Factories\\";
    }

    public function getUserData($request): array
    {
        $results = [];
        foreach ($this->providers as $provider) {
            $providerFactoryName = $this->providersNamespace . $provider . "Factory";
            throw_if(!class_exists($providerFactoryName), new \Exception("Provider {$provider} Not Found"));
            $providerFactoryObject = new $providerFactoryName();
            $results = array_merge($results, $providerFactoryObject->createProvider()->loadData());
        }
        return $this->applyFilters($request, $results);
    }

    protected function setProviders(): void
    {
        $this->providers = [
            'DataProviderX',
            'DataProviderY'
        ];
    }

    /**
     * @param $request
     * @param $data
     * @return array
     */
    private function applyFilters($request, $data): array
    {
        $data = collect($data);

        if ($request->filled('provider')) {
            $data = $data->where('provider', $request->provider);
        }

        if ($request->filled('statusCode')) {
            $data = $data->where('status', $request->statusCode);
        }

        if ($request->filled('balanceMin') && $request->filled('balanceMax')) {
            $data = $data->whereBetween('amount', [$request->balanceMin, $request->balanceMax]);
        }

        if ($request->filled('currency')) {
            $data = $data->where('currency', $request->currency);
        }

        return $data->values()->all();
    }
}
