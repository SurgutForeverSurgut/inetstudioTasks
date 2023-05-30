<?php

interface HTTPServiceInterface 
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function request(string $url, string $method, array $options = []);
} 

class XMLHttpService implements HTTPServiceInterface 
{
    public function request(string $url, string $method, array $options = []){ }
}

class Http 
{
    private $httpService;

    public function __construct(HTTPServiceInterface $httpService) {
        $this->httpService = $httpService;
    }

    public function get(string $url, array $options) {
        $this->httpService->request($url, HTTPServiceInterface::METHOD_GET, $options);
    }

    public function post(string $url) {
        $this->httpService->request($url, HTTPServiceInterface::METHOD_POST);
    }
}