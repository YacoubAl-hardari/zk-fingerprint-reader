<?php

namespace Yacoubalhaidari\ZKFinger\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ZKFingerAgentClient
{
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('zkfinger.agent_base_url'), '/');
        $this->timeout = config('zkfinger.timeout', 30);
    }

    public function enroll(string $userId): array
    {
        return $this->request('POST', '/enroll', ['user_id' => $userId]);
    }

    public function capture(): array
    {
        return $this->request('POST', '/capture');
    }

    public function verify1To1(string $regTemplateB64, string $verTemplateB64): array
    {
        return $this->request('POST', '/verify/1:1', [
            'reg_template' => $regTemplateB64,
            'ver_template' => $verTemplateB64,
            'threshold' => config('zkfinger.verify_threshold'),
            'do_learning' => true,
        ]);
    }

    public function identify1ToN(string $verTemplateB64, int $cacheHandle = 1): array
    {
        return $this->request('POST', '/identify/1:N', [
            'ver_template' => $verTemplateB64,
            'cache_handle' => $cacheHandle,
            'threshold' => config('zkfinger.verify_threshold'),
        ]);
    }

    public function createCacheDB(): array
    {
        return $this->request('POST', '/cache/create');
    }

    public function addToCacheDB(int $cacheHandle, string $fpid, string $templateB64): array
    {
        return $this->request('POST', '/cache/add', [
            'cache_handle' => $cacheHandle,
            'fpid' => $fpid,
            'template' => $templateB64,
        ]);
    }

    protected function request(string $method, string $uri, array $data = []): array
    {
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout($this->timeout)
                ->send($method, "{$this->baseUrl}{$uri}", ['json' => $data]);

            $body = $response->json();

            if (!$response->successful() || ($body['success'] ?? false) === false) {
                throw new Exception($body['message'] ?? 'Agent request failed');
            }

            return $body;
        } catch (Exception $e) {
            Log::error('ZKFinger Agent Error', ['message' => $e->getMessage(), 'uri' => $uri]);
            throw $e;
        }
    }
}
