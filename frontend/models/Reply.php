<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "reply".
 *
 * @property int $id
 * @property string|null $dt_add
 * @property int|null $rate
 * @property string|null $description
 * @property int $contractor_id
 * @property int $task_id
 *
 * @property User $contractor
 * @property Task $task
 */
class Reply extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reply';
    }

    /**
     * @param string $dt_add
     * @param int $rate
     * @param string $description
     * @param int $contractor_id
     * @param int $task_id
     */
    public static function saveModel(
        $dt_add, $rate, $description,
        $contractor_id, $task_id): void
    {
        $props = [
            'dt_add' => $dt_add,
            '$task_id' => $rate,
            'description' => $description,
            'contractor_id' => $contractor_id,
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
    public static function getReply(int $id)
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
            [['rate', 'contractor_id', 'task_id'], 'integer'],
            [['contractor_id', 'task_id'], 'required'],
            [['description'], 'string', 'max' => 1000],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
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
            'contractor_id' => 'Contractor ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
