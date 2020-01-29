<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $dt_add
 * @property int $category_id
 * @property string|null $description
 * @property string|null $expire
 * @property string|null $name
 * @property string|null $address
 * @property int|null $budget
 * @property float|null $lat
 * @property float|null $long
 * @property int $client_id
 * @property int|null $contractor_id
 *
 * @property Opinion[] $opinions
 * @property Reply[] $replies
 * @property Category $category
 * @property User $client
 * @property User $contractor
 */
class Task extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * Saves model with existing params
     * using mass assignment. Requires rules()
     * @param string $dt_add
     * @param int $category_id
     * @param string $description
     * @param string $expire
     * @param string $name
     * @param string $address
     * @param int $budget
     * @param float $lat
     * @param float $long
     * @param int $client_id
     * @param int $contractor_id
     */

    public static function saveModel(
         $dt_add, $category_id,
         $description, $expire,

         $name, $address,
         $budget, $lat, $long,
         $client_id, $contractor_id): void
    {
        $props = [
            'dt_add' => $dt_add,
            'category_id' => $category_id,
            'description' => $description,
            'expire' => $expire,
            'name' => $name,
            'address' => $address,
            'budget' => $budget,
            'lat' => $lat,
            'long' => $long,
            'client_id' => $client_id,
            'contractor_id' => $contractor_id
        ];
        $city = new self();
        $city->attributes = $props;

        $city->save();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dt_add', 'expire'], 'safe'],
            [['category_id', 'client_id'], 'required'],
            [['category_id', 'budget', 'client_id', 'contractor_id'], 'integer'],
            [['lat', 'long'], 'number'],
            [['description'], 'string', 'max' => 1500],
            [['name'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 500],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
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
            'category_id' => 'Category ID',
            'description' => 'Description',
            'expire' => 'Expire',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'lat' => 'Lat',
            'long' => 'Long',
            'client_id' => 'Client ID',
            'contractor_id' => 'Contractor ID',
        ];
    }

    /**
     * @param int
     * @return ActiveRecord
     */
    public static function getTask(int $id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * @return ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::class, ['task_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::class, ['id' => 'contractor_id']);
    }
}
