<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObject\Auth\SaveData;
use App\Http\DataTransferObject\User\UserData;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        protected UserService $userService
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::select([
            'id',
            'name',
            'email',
            'address',
            'age'
        ])->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(User::create(UserData::from($request)), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->userService->show($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->userService->update(UserData::from($request), $id), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): jsonResponse
    {
        $this->userService->delete($id);
        return response()->json(null, 204);
    }
}
