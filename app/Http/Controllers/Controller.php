<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function onesignal($message, $userIds)
    {
        if ($message) {
            $playerIds = $userIds;
            $message = ['en' => $message];
            $data = [
                'app_id' => env('ONESIGNAL_APP_ID'),
                'include_player_ids' => $playerIds,
                'contents' => $message,
            ];
            $ch = curl_init('https://onesignal.com/api/v1/notifications');
    
            $options = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => '',
                CURLOPT_USERAGENT => 'PHP',
                CURLOPT_AUTOREFERER => true,
                CURLOPT_CONNECTTIMEOUT => 120,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . env('ONESIGNAL_REST_API_KEY'),
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
            ];
    
            curl_setopt_array($ch, $options);
    
            $response = curl_exec($ch);
            if ($response === false) {
                $error = 'cURL Error: ' . curl_error($ch);
                curl_close($ch);
                return ['success' => false, 'error' => $error];
            }
    
            curl_close($ch);
            return ['success' => true, 'response' => json_decode($response, true)];
        }
    
        return ['success' => false, 'error' => 'Invalid notification'];
    }
    
}
