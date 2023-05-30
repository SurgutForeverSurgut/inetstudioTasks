<?php

interface KeySecretInterface {
    public function storeSecretKey(string $token): bool;
    public function getSecretKey(): string;
}

class Concept{
    private $client;
    private $storageInstance;

    public function __construct(string $storageType, string $token) {
        $this->client = new \GuzzleHttp\Client();
        $this->storageInstance = $this->getStorageInstance($storageType);
        $this->storageInstance->storeSecretKey($token);
    }

    private function getStorageInstance($storageType): KeySecretInterface {
        switch ($storageType) {
            case 'file':
                return new KeyStorageFile();
            case 'db':
                return new KeyStorageDB();
            case 'redis':
                return new KeyStorageRedis();
            default:
                throw new InvalidArgumentException("Invalid storage type");
        }
    }

    public function getSecretKey(): string{
        return $this->storageInstance->getSecretKey();
    }

    public function getUserData() {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }
}

class KeyStorageFile implements KeySecretInterface {
    public function getSecretKey(): string {
        // реализация
        return 'file-key-secret ';
    }

    public function storeSecretKey($token): bool {
        // реализация
        return true;
    }
}

class KeyStorageDB implements KeySecretInterface {
    public function getSecretKey(): string {
        // реализация
        return 'db-key-secret ';
    }

    public function storeSecretKey($token): bool {
        // реализация
        return true;
    }
}

class KeyStorageRedis implements KeySecretInterface {
    public function getSecretKey(): string {
        // реализация
        return 'redis-key-secret ';
    }

    public function storeSecretKey($token): bool {
        // реализация
        return true;
    }
}

// берём из кофига / .env
$storageType = 'redis';
$concept = new Concept($storageType, md5($storageType));
$concept->getUserData();