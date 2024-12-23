<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;
use app\models\Repository;

class RepoController extends Controller
{
    public function actionIndex(): string
    {
        $repositories = Repository::find()
            ->orderBy(['updated_at' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('index', ['repositories' => $repositories]);
    }
}
