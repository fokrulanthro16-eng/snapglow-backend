<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ToolHistory;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Throwable;

#[OA\Tag(
    name: 'Tool Histories',
    description: 'SnapGlow tool usage history endpoints'
)]
class ToolHistoryController extends Controller
{
    #[OA\Get(
        path: '/api/tool-histories',
        tags: ['Tool Histories'],
        summary: 'Get all tool histories',
        responses: [
            new OA\Response(response: 200, description: 'Tool histories fetched successfully')
        ]
    )]
    public function index()
    {
        try {
            $histories = ToolHistory::latest()->get();

            return response()->json([
                'success' => true,
                'message' => 'Tool histories fetched successfully',
                'data' => $histories,
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tool histories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Post(
        path: '/api/tool-histories',
        tags: ['Tool Histories'],
        summary: 'Create a tool history',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['tool_type', 'input_file'],
                properties: [
                    new OA\Property(property: 'tool_type', type: 'string', example: 'compress_photo'),
                    new OA\Property(property: 'input_file', type: 'string', example: 'uploads/original/photo1.jpg'),
                    new OA\Property(property: 'output_file', type: 'string', example: 'uploads/compressed/photo1.jpg'),
                    new OA\Property(property: 'original_size_kb', type: 'integer', example: 2048),
                    new OA\Property(property: 'processed_size_kb', type: 'integer', example: 640),
                    new OA\Property(property: 'status', type: 'string', example: 'completed'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Tool history created successfully'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 500, description: 'Server error'),
        ]
    )]
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tool_type' => ['required', 'string', 'max:255'],
                'input_file' => ['required', 'string', 'max:255'],
                'output_file' => ['nullable', 'string', 'max:255'],
                'original_size_kb' => ['nullable', 'integer'],
                'processed_size_kb' => ['nullable', 'integer'],
                'status' => ['nullable', 'string', 'max:255'],
            ]);

            $history = ToolHistory::create([
                'tool_type' => $validated['tool_type'],
                'input_file' => $validated['input_file'],
                'output_file' => $validated['output_file'] ?? null,
                'original_size_kb' => $validated['original_size_kb'] ?? null,
                'processed_size_kb' => $validated['processed_size_kb'] ?? null,
                'status' => $validated['status'] ?? 'completed',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tool history created successfully',
                'data' => $history,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tool history',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Get(
        path: '/api/tool-histories/{id}',
        tags: ['Tool Histories'],
        summary: 'Get single tool history',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Tool history ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tool history fetched successfully'),
            new OA\Response(response: 404, description: 'Tool history not found'),
        ]
    )]
    public function show(int $id)
    {
        try {
            $history = ToolHistory::find($id);

            if (! $history) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool history not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tool history fetched successfully',
                'data' => $history,
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tool history',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    #[OA\Delete(
        path: '/api/tool-histories/{id}',
        tags: ['Tool Histories'],
        summary: 'Delete a tool history',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Tool history ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Tool history deleted successfully'),
            new OA\Response(response: 404, description: 'Tool history not found'),
        ]
    )]
    public function destroy(int $id)
    {
        try {
            $history = ToolHistory::find($id);

            if (! $history) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool history not found',
                ], 404);
            }

            $history->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tool history deleted successfully',
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tool history',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
