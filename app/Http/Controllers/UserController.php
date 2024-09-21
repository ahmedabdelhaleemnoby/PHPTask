<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getAllUsers());
    }

    public function show($id)
    {
        return response()->json($this->userService->findUser($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users',
        ]);

        $user = $this->userService->createUser($data);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:8',
            'phone' => 'sometimes|unique:users,phone,' . $id,
        ]);

        $user = $this->userService->updateUser($id, $data);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return response()->json(null, 204);
    }
}
