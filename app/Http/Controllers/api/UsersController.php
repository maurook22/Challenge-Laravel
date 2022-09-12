<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse
    {

        try {

            return response()->json($this->userRepository->all());

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'Error',
                'infoError' => $e
            ]);

        }
    }
}
