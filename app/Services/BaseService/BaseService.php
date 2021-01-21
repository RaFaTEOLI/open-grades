<?php

namespace App\Services\BaseService;

use Exception;

class BaseService
{
    private $baseRepository;

    public function __construct()
    {
        // Uncomment next line
        // $this->baseRepository = (new BaseRepository());
    }

    public function execute(array $request) {
        try {
            // Your Code
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
