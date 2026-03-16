<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'SnapGlow Backend API',
    description: 'API documentation for SnapGlow backend'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Local server'
)]
class SwaggerTestController extends Controller
{
    #[OA\Get(
        path: '/api/test',
        tags: ['Test'],
        summary: 'Test API',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success'
            )
        ]
    )]
    public function test()
    {
        return response()->json([
            'message' => 'Swagger working',
        ]);
    }
}
