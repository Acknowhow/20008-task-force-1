<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property int $contractor_id
 *
 * @property User $contractor
 */
class Profile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * Saves model with existing params
     * using mass assignment. Requires rules()
     * @param string $address
     * @param int $bd
     * @param string $about
     * @param string $phone
     * @param string $skype
     * @param int $contractor_id
     */
    public static function saveModel(
        $address, $bd, $about, $phone,
        $skype, $contractor_id): void
    {
        $props = [
            'address' => $address,
            'bd' => $bd,
            'about' => $about,
            'phone' => $phone,
            'skype' => $skype,
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
            [['bd'], 'safe'],
            [['contractor_id'], 'required'],
            [['contractor_id'], 'integer'],
            [['address'], 'string', 'max' => 100],
            [['about'], 'string', 'max' => 1000],
            [['phone'], 'string', 'max' => 20],
            [['skype'], 'string', 'max' => 50],
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
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
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
    public function getContractor()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
    }
}
