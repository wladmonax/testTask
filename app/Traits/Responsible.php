<?php


namespace App\Traits;

use Illuminate\Support\Facades\Log;

/**
 * Class Responsible
 * @package App\Traits
 */
trait Responsible
{
    /**
     * @param $data
     * @param $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponseJSON($data, $statusCode, array $headers = [])
    {
        return response()
            ->json(
                [
                    'data' => $data,
                    'status' => $statusCode
                ],
                $statusCode,
                $headers
            );

    }

    /**
     * @param $message
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function failResponseJSON($message, $statusCode, array $headers = [])
    {
        $result =  response()
            ->json(
                [
                    'error' => [
                        'message' => $message
                    ],
                    'status' => $statusCode
                ],
                $statusCode,
                $headers
            );



        Log::channel('general')->error(
            $message
        );

        return $result;
    }

}
