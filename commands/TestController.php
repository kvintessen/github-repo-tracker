<?php

declare(strict_types=1);

namespace app\commands;

use app\models\Repository;
use yii\console\Controller;
use app\services\GitHubService;
use app\models\GithubUser;
use yii\base\Exception;

class TestController extends Controller
{
    public function actionRepos()
    {
        // Массив из 10 GitHub пользователей
        $usernames = [
            'torvalds',
            'gaearon',
            'mojombo',
            'defunkt',
            'pjhyett',
            'wycats',
            'ezmobius',
            'ivey',
            'evanphx',
            'vanpelt',
        ];

        $service = new GitHubService();

        foreach ($usernames as $username) {
            try {
                $user = GithubUser::findOne(['username' => $username]);

                if (!$user) {
                    $user = new GithubUser(['username' => $username]);
                    if (!$user->save()) {
                        $this->stderr("Не удалось сохранить пользователя '{$username}': " . implode(', ', $user->getFirstErrors()) . "\n");
                        continue;
                    }
                }


                $repos = $service->getUserRepositories($username, 1);

                if (empty($repos)) {
                    $this->stdout("У пользователя '{$username}' нет репозиториев.\n");
                    continue;
                }

                foreach ($repos as $repoData) {
                    $repository = Repository::findOrCreateAndUpdate($user->id, $repoData);
                }

                $this->stdout("Репозитории для пользователя '{$username}' успешно обновлены.\n");

            } catch (\Exception $e) {
                $this->stderr("Ошибка при обработке пользователя '{$username}': {$e->getMessage()}\n");
            }
        }

        $this->stdout("Обработка всех пользователей завершена.\n");
    }
}
