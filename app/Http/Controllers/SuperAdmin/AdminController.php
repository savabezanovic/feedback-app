<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\SuperAdminRequest;
use App\Http\Requests\UpdateAdminPasswordRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(SuperAdminRequest $request)
    {
        $admins = $this->userService->admins();

        return response()->json(['admins' => $admins]);
    }

    public function show(SuperAdminRequest $request, $id)
    {
        $admin = $this->userService->find($id);

        return view('superadmin.admins.single', compact('admin'));
    }

    public function store(CreateAdminRequest $request)
    {
        $this->userService->createAdmin($request);

        return response()->json(['success' => 'Admin is created']);
    }

    public function edit(SuperAdminRequest $request, $id)
    {
        $admin = $this->userService->find($id);

        return response()->json(['admin' => $admin]);
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        $admin = $this->userService->update($request, $id);

        return response()->json(['admin', $admin]);
    }

    public function updatePassword(UpdateAdminPasswordRequest $request, $id)
    {
        $admin = $this->userService->updatePassword($request, $id);

        return response()->json(['admin', $admin]);
    }

    public function destroy(SuperAdminRequest $request, $id)
    {
        $this->userService->delete($id);

        return response()->json(['success' => 'User is deleted']);
    }
}
