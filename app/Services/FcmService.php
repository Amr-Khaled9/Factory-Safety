<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected $client;
    protected $projectId;
    protected $accessToken;

    /**
     * FcmService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        // تأكد من أن اسم هذا الملف يطابق اسم ملف credentials الخاص بمشروعك الحقيقي
        $credentialsFilePath = storage_path('app/titan-73-firebase-adminsdk-fbsvc-5444706405.json');

        if (!file_exists($credentialsFilePath)) {
            Log::error('FCM credentials file not found at: ' . $credentialsFilePath);
            // في بيئة الإنتاج، قد لا ترغب في إيقاف التطبيق بالكامل
            // يمكنك فقط تسجيل الخطأ والخروج من الدالة
            throw new \Exception('FCM credentials file not found!');
        }

        $this->client = new GoogleClient();
        $this->client->setAuthConfig($credentialsFilePath);
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging' );

        // قراءة معرف المشروع تلقائيًا من ملف JSON
        $config = json_decode(file_get_contents($credentialsFilePath), true);
        $this->projectId = 'titan-73';

        if (!$this->projectId) {
            Log::error('Project ID not found in FCM credentials file.');
            throw new \Exception('Project ID not found in FCM credentials file.');
        }
    }

    /**
     * يحصل على Access Token صالح.
     * @return mixed
     * @throws \Exception
     */
    protected function getAccessToken()
    {
        // إذا كان لدينا توكن صالح، نستخدمه مباشرة لتوفير الوقت
        if ($this->accessToken && !$this->client->isAccessTokenExpired()) {
            return $this->accessToken;
        }

        // إذا لم يكن لدينا توكن أو انتهت صلاحيته، نطلب واحدًا جديدًا
        $this->client->refreshTokenWithAssertion();
        $tokenData = $this->client->getAccessToken();
        $this->accessToken = $tokenData['access_token'];

        return $this->accessToken;
    }

    /**
     * يرسل إشعارًا إلى جهاز معين.
     *
     * @param string $fcmToken The device token.
     * @param string $title The notification title.
     * @param string $body The notification body.
     * @param array $data Optional data payload.
     * @return array
     */
    public function sendNotification(string $fcmToken, string $title, string $body, array $data = [])
    {
        try {
            $accessToken = $this->getAccessToken();
        } catch (\Exception $e) {
            Log::error('FCM - Failed to get access token: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Failed to get access token.'];
        }

        $headers = [
            "Authorization: Bearer " . $accessToken,
            'Content-Type: application/json'
        ];

        $messageData = [
            "message" => [
                "token" => $fcmToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                // يمكنك إرسال بيانات إضافية هنا ليقرأها التطبيق
                "data" => !empty($data) ? $data : null,
            ]
        ];
        $payload = json_encode($messageData);

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $ch = curl_init( );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // يفضل دائمًا تفعيل هذا في بيئة الإنتاج للأمان
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            Log::error('FCM Curl Error: ' . $err);
            return ['success' => false, 'error' => $err];
        }

        $decodedResponse = json_decode($response, true);

        // التحقق من وجود خطأ في استجابة الـ API
        if (isset($decodedResponse['error'])) {
            Log::error('FCM API Error: ' . json_encode($decodedResponse));
            return ['success' => false, 'response' => $decodedResponse];
        }

        Log::info('VVVVFCM Notification sent successfully to token: ' . substr($fcmToken, 0, 20) . '...');
        return ['success' => true, 'response' => $decodedResponse];
    }
}