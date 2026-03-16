<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="SnapGlow Backend API",
 *     description="API documentation for SnapGlow Backend"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local server"
 * )
 */
class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     tags={"Test"},
     *     summary="Test API endpoint",
     *     description="Returns a simple success message",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Controller API working successfully")
     *         )
     *     )
     * )
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'message' => 'Controller API working successfully',
        ]);
    }
}
