<?php

declare(strict_types=1);

namespace app\services;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class GitHubService
{
    private const BASE_URL = 'https://api.github.com';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'baseUrl' => self::BASE_URL,
        ]);
    }

    /**
     * @throws \yii\httpclient\Exception
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getUserRepositories(string $username, ?int $limit = null): array
    {
        $request = $this->client->createRequest()
            ->setMethod('GET')
            ->setUrl("/users/{$username}/repos")
            ->addHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Yii2-Github-App',
            ]);

        // Добавляем параметр per_page, если указан лимит
        if ($limit !== null) {
            // GitHub API позволяет максимум 100 репозиториев на страницу
            $limit = min($limit, 100);
            $request->setData(['per_page' => $limit]);
        }

        $response = $request->send();

        if (!$response->isOk) {
            throw new Exception('Ошибка при получении данных из GitHub API: ' . $response->content);
        }

        return $response->data;
    }
}
