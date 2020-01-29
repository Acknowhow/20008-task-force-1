<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "opinion".
 *
 * @property int $id
 * @property string|null $dt_add
 * @property int|null $rate
 * @property string|null $description
 * @property int $client_id
 * @property int $task_id
 *
 * @property User $client
 * @property Task $task
 */
class Opinion extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinion';
    }

    /**
     * Saves model with existing params
     * using mass assignment. Requires rules()
     * @param string $dt_add
     * @param int $rate
     * @param string $description
     * @param int $client_id
     * @param int $task_id
     * @return void
     */

    public static function saveModel(
        $dt_add, $rate,
        $description, $client_id, $task_id): void
    {
        $props = [
            'dt_add' => $dt_add,
            'rate' => $rate,
            'description' => $description,
            'client_id' => $client_id,
            'task_id' => $task_id
        ];
        $city = new self();
        $city->attributes = $props;

        $city->save();
    }

    /**
     * @param int
     * @return ActiveRecord
     */
    public static function getOpinion(int $id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add'], 'safe'],
            [['rate', 'client_id', 'task_id'], 'integer'],
            [['client_id', 'task_id'], 'required'],
            [['description'], 'string', 'max' => 1500],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'description' => 'Description',
            'client_id' => 'Client ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
