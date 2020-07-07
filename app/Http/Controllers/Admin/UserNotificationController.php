<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Services\CompanyAdminNotificationsService;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    /**
     * @var CompanyAdminNotificationsService
     */
    private $companyAdminNotificationsService;

    public function __construct(CompanyAdminNotificationsService $companyAdminNotificationsService)
    {
        $this->companyAdminNotificationsService = $companyAdminNotificationsService;
    }

    public function index(AdminRequest $request)
    {
        return view('admin-notification-test');
    }

    public function messageToAll(AdminRequest $request)
    {
        $this->companyAdminNotificationsService->sendMessageToAllUsers($request->message);

        return response()->json(['success' => 'Message sent.']);
    }
}
