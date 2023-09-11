<?php

namespace App\FactoryMethod\ProviderTypes;

use App\FactoryMethod\DataProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DataProviderY implements DataProviderInterface
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
                $createdAtData = Carbon::createFromFormat('d/m/Y' , $item['created_at'])->format('Y-m-d');
                $providerData[] = [
                    'id' => $item['id'] ?? '',
                    'email' => $item['email'] ?? '',
                    'amount' => $item['balance'] ?? '',
                    'currency' => $item['currency'] ?? '',
                    'status' => $this->getStatusName($item['status']),
                    'created_at' => $createdAtData?? '',
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
            100 => 'authorised',
            200 => 'decline',
            300 => 'refunded',
        ];
    }
}
