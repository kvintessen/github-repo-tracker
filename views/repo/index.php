<?php
/** @var yii\web\View $this */
/** @var app\models\Repository[] $repositories */

use yii\helpers\Html;

$this->title = 'Последние обновленные репозитории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repository-latest">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($repositories)): ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Ссылка</th>
                <th>Дата обновления</th>
                <th>Пользователь</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($repositories as $repo): ?>
                <tr>
                    <td><?= Html::encode($repo->name) ?></td>
                    <td><?= Html::a('Открыть', Html::encode($repo->url), ['target' => '_blank']) ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($repo->updated_at) ?></td>
                    <td><?= Html::encode($repo->user->username) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Репозитории не найдены.</p>
    <?php endif; ?>

</div>
