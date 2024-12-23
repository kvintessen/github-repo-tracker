<?php

declare(strict_types=1);

namespace app\commands;

use yii\console\Controller;
use app\services\GitHubService;
use app\models\Repository;
use app\models\GithubUser;

class UpdateController extends Controller
{
    public function actionRepositories()
    {
        $service = new GitHubService();
        $users = GithubUser::find()->all();

        /** @var GithubUser $user */
        foreach ($users as $user) {
            echo "Обновление репозиториев для пользователя: {$user->username}\n";

            try {
                $repos = $service->getUserRepositories($user->username);

                foreach ($repos as $repoData) {
                    $repository = Repository::findOrCreateAndUpdate($user->id, $repoData);
                }
            } catch (\Exception $e) {
                echo "Ошибка при обновлении репозиториев пользователя {$user->username}: {$e->getMessage()}\n";
            }
        }

        echo "Обновление завершено.\n";
    }
}
