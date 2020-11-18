<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Traits\Responsible;
use Illuminate\Http\Request;

/**
 * Class NotificationsController
 * @package App\Http\Controllers\Web
 */
class NotificationsController extends Controller
{
    use Responsible;

    /** @var NotificationService */
    public $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $notes = $this->notificationService
            ->listOfNotifications();

        return view('home', ['notes' => $notes]);
    }

}
