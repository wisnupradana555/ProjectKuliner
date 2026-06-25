<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $validApiKey = env('API_KEY', 'kuliner-sk-4f8a2b9c3d1e7f6a');
        $apiKey = $request->getHeaderLine('Authorization');

        if ($apiKey !== $validApiKey) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON([
                'status'  => 'error',
                'message' => 'Unauthorized. API Key tidak valid atau tidak disertakan.',
                'hint'    => 'Sertakan header: Authorization: [your-api-key]'
            ]);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
