<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\FcmService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times to retry the job if it fails.
     */
    public int $tries = 3;

    public function __construct(
        protected string $title,
        protected string $message,
        protected Notification $notification
    ) {}

    public function handle(FcmService $fcmService): void
    {
        // 1) Push notification — only users with an FCM token
        $usersWithFcm = User::whereHas('fcmToken')->with('fcmToken')->get();

        foreach ($usersWithFcm as $user) {
            if ($user->fcmToken && $user->fcmToken->fcm_token) {
                $result = $fcmService->sendNotification(
                    $user->fcmToken->fcm_token,
                    $this->title,
                    $this->message
                );

                if (!($result['success'] ?? false)) {
                    Log::warning("FCM push failed for user {$user->id}: " . json_encode($result));
                }
            }
        }

        // 2) Database + broadcast notification — ALL users
        $allUsers = User::all();

        foreach ($allUsers as $user) {
            $user->notify($this->notification);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendNotificationJob failed: ' . $exception->getMessage());
    }
}
