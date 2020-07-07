<?php


namespace App\Services;

use App\Notifications\CompanyAdminMessage;
use Illuminate\Support\Facades\Notification;

class CompanyAdminNotificationsService
{
    public function sendMessageToAllUsers($message)
    {
        Notification::send(auth()->user()->company->adminListUsers(), new CompanyAdminMessage($message)); // sending to collection of users using facade
    }
}
