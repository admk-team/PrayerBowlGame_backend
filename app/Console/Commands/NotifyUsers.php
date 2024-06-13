<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReminderNotification;
use App\Models\TopWarrior;
use App\Models\PreviousTopWarrior;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotifyUsers extends Command
{
    protected $signature = 'notify:users';
    protected $description = 'Send notifications to users based on their reminders and top warriors ranking';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentDateTime = Carbon::now()->second(0)->microsecond(0); // Current time with seconds and microseconds set to 0

        // Fetch reminders where the type is enabled
        $reminderdata = ReminderNotification::where('type', 'enabled')->get();

        foreach ($reminderdata as $remind) {
            if ($this->shouldSendNotification($remind, $currentDateTime)) {
                $checkuser = User::where('id', $remind->user_id)->whereNotNull('sub_id')->first();

                if ($checkuser && $checkuser->sub_id) {
                    $message = __('This time to pray. Pause and reflect.');
                    $userIds = [$checkuser->sub_id];

                    if (!empty($message) && !empty($userIds)) {
                        $result = $this->onesignal($message, $userIds);
                    }
                }
            }
        }
        $this->info('User reminder notifications have been sent successfully.');

        // Get current top 3 warriors
        $topWarriors = TopWarrior::with('user')
            ->orderByDesc('count')
            ->take(3)
            ->get();

        // Get previous top 3 warriors from the database
        $previousTopWarrior = PreviousTopWarrior::first();
        $previousTopWarriors = $previousTopWarrior ? $previousTopWarrior->warriors : [];

        // Convert current top warriors to an array of user_id and count
        $currentTopWarriors = $topWarriors->map(function($warrior) {
            return ['user_id' => $warrior->user_id, 'count' => $warrior->count];
        })->toArray();

        // Check if the top 3 warriors have changed in order or if it's the first run
        if ($this->hasTopWarriorsChanged($currentTopWarriors, $previousTopWarriors)) {
            foreach ($topWarriors as $top) {
                if ($top->user && $top->user->sub_id) {
                    $message = __('You are in the top 3 prayer warriors today. Keep it up!');
                  
                    $userIds = [$top->user->sub_id];

                    if (!empty($message) && !empty($userIds)) {
                        $result = $this->onesignal($message, $userIds);
                    }
                }
            }

            // Update the previous top warriors in the database
            if ($previousTopWarrior) {
                $previousTopWarrior->update(['warriors' => $currentTopWarriors]);
            } else {
                PreviousTopWarrior::create(['warriors' => $currentTopWarriors]);
            }
        }

        $this->info('Top 3 Warrior notifications have been sent successfully.');
    }

    private function shouldSendNotification($remind, $currentDateTime)
    {
        $start = Carbon::parse($remind->start_datetime)->second(0)->microsecond(0);
        $duration = $remind->duration;

        switch ($duration) {
            case 'day':
                return $currentDateTime->format('H:i') === $start->format('H:i');
            case 'week':
                return $currentDateTime->isSameDayOfWeek($start) && $currentDateTime->format('H:i') === $start->format('H:i');
            default:
                return false;
        }
    }

    private function hasTopWarriorsChanged($currentTopWarriors, $previousTopWarriors)
    {
        // Compare the current and previous top 3 warriors by user_id and their positions
        for ($i = 0; $i < 3; $i++) {
            if (!isset($currentTopWarriors[$i]) || !isset($previousTopWarriors[$i]) ||
                $currentTopWarriors[$i]['user_id'] !== $previousTopWarriors[$i]['user_id'] ||
                $currentTopWarriors[$i]['count'] !== $previousTopWarriors[$i]['count']) {
                return true;
            }
        }
        return false;
    }

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
