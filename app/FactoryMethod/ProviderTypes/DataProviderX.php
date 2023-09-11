<?php

namespace App\FactoryMethod\ProviderTypes;

use App\FactoryMethod\DataProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DataProviderX implements DataProviderInterface
{

    private string $fileName;
    private array $statues;

    public function __construct()
    {
        $this->fileName = (new \ReflectionClass(__CLASS__))->getShortName();
        $this->setStatuses();
    }

    public function loadData(): array
    {
        $providerData = [];
        $filePath = public_path() . "/providers/{$this->fileName}.json";
        if (File::exists($filePath)) {
            $data = json_decode(File::get($filePath), true);
            foreach ($data as $item) {
                $providerData[] = [
                    'id' => $item['parentIdentification'] ?? '',
                    'email' => $item['parentEmail'] ?? '',
                    'amount' => $item['parentAmount'] ?? '',
                    'currency' => $item['Currency'] ?? '',
                    'status' => $this->getStatusName($item['statusCode']),
                    'created_at' => Carbon::parse($item['registerationDate'])->format('Y-m-d') ?? '',
                    'provider' => $this->fileName,
                ];
            }
        }
        return $providerData;
    }

    public function getStatusName($status): string
    {
        return array_key_exists($status, $this->statues) ? $this->statues[$status] : '';
    }

    public function setStatuses(): void
    {
        $this->statues = [
            1 => 'authorised',
            2 => 'decline',
            3 => 'refunded',
        ];
    }
}
