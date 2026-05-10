<?php
return [
    'agent_base_url' => env('ZKFINGER_AGENT_URL', 'http://127.0.0.1:8080'),
    'timeout' => 30,
    'verify_threshold' => env('ZKFINGER_THRESHOLD', 10), // 1-100 (per SDK Sec 4.1.15)
    'engine_version' => env('ZKFINGER_ENGINE_VERSION', '9'), // '9' or '10' (Sec 4.1.5)
    'template_type' => env('ZKFINGER_TEMPLATE_TYPE', '1:1'), // '1:1' or '1:N'
];
