<?php

return [

    'default' => 'app', // 👈 هنا الحل

    'projects' => [

        'app' => [
            'credentials' => env(
                'FIREBASE_CREDENTIALS',
                storage_path('app/firebase-credentials.json')
            ),
        ],

    ],

];

