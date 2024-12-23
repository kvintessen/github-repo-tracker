<?php

namespace app\models;

use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "repositories".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $url
 * @property string|null $updated_at
 *
 * @property GithubUser $user
 */
class Repository extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'repositories';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'name', 'url'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => GithubUser::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'url' => 'Url',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(GithubUser::class, ['id' => 'user_id']);
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public static function findOrCreateAndUpdate(int $userId, array $repoData): ?self
    {
        $repository = self::findOne([
            'user_id' => $userId,
            'name' => $repoData['name'],
        ]);

        if (!$repository) {
            $repository = new self();
            $repository->user_id = $userId;
        }

        $repository->name = $repoData['name'];
        $repository->url = $repoData['html_url'];
        $repository->updated_at = $repoData['updated_at'];

        if (!$repository->save()) {
            $errorMessage = "Не удалось сохранить репозиторий '{$repository->name}' для пользователя ID '{$userId}': " . implode(', ', $repository->getFirstErrors());
            \Yii::error($errorMessage, __METHOD__);
            throw new Exception($errorMessage);
        }

        return $repository;
    }
}
