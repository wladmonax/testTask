<?php

namespace App\Http\Controllers\Api;

use App\Entities\Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Services\NotificationService;
use App\Traits\Responsible;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class NotificationController
 * @package App\Http\Controllers\Api
 */
class NotificationController extends Controller
{
    use Responsible;

    /** @var NotificationService */
    public $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->notificationService
            ->listOfNotifications();

        return $this->successResponseJSON(
            $data,
            Response::HTTP_CREATED
        );
    }

    /**
     * @param StoreNotificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNotificationRequest $request)
    {
        /** @var Notification $notification */
        $notification = $this->notificationService
            ->store($request->all());

        if (!$notification) {
            return $this->failResponseJSON('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->successResponseJSON(
            $notification,
            Response::HTTP_CREATED
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->notificationService
            ->delete($id);

        return $this->successResponseJSON(
            [],
            Response::HTTP_OK
        );
    }
}
