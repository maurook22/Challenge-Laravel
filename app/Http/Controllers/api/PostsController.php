<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{

    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function top(): JsonResponse
    {

        try {

            return response()->json($this->postRepository->top());

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'Error',
                'infoError' => $e
            ]);
        }
    }

    public function show($id): JsonResponse
    {

        try {

            $data = $this->postRepository->get($id);
            
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'Error',
                'infoError' => $e
            ]);
        }

        if (count($data) != 1) return response()->json([
            'message' => 'Post no encontrado.'
        ], 404);

        return response()->json($data);
    }
}
