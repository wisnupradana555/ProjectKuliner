<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiKeyFilter implements FilterInterface
{
    // API Key yang valid — bisa diubah sesuai kebutuhan
    private const VALID_API_KEY = 'kuliner-api-key-udinus-2026';

    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil API Key dari header request
        $apiKey = $request->getHeaderLine('X-API-Key');

        // Jika API Key tidak ada atau salah, tolak request
        if ($apiKey !== self::VALID_API_KEY) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON([
                'status'  => 'error',
                'message' => 'Unauthorized. API Key tidak valid atau tidak disertakan.',
                'hint'    => 'Sertakan header: X-API-Key: kuliner-api-key-udinus-2026'
            ]);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah response
    }
}
