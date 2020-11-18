<?php

namespace App\Services;

use App\Entities\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class NotificationService
{
    /** @var NotificationRepository */
    public $notificationRepository;

    /**
     * NotificationService constructor.
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @return mixed
     * Pagination was done on front end, but can be done on back end.
     */
    public function listOfNotifications()
    {
        /** @var Notification[] $notifications */
        $notifications = $this->notificationRepository
            ->all();
        foreach ($notifications as $notification) {
            $notification->image = $notification->imagePath;
        }

        return $notifications;
    }

    /**
     * @param $data
     * @return Notification
     */
    public function store($data)
    {

        try {
            if (request()->file('image')) {
                $fileName = request()->file('image')->getClientOriginalName();
            } else {
                $fileName = '';
            }

            /** @var Notification $notification */
            $notification = $this->notificationRepository
                ->create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'imageName' => $fileName
                ]);

            $this->storeFile($data, $fileName, $notification->id);

            return $notification;

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }

    }

    /**
     * @param $data
     * @param $fileName
     * @param $id
     */
    private function storeFile($data, $fileName, $id)
    {
        if ($fileName !== '') {
            $img = Image::make($data['image']);
            $path = storage_path('app/public/images/' . $id);
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $img->save($path . '/' . $fileName);
        }
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->notificationRepository
            ->delete($id);
    }

}
