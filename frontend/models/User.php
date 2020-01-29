<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * Saves model with existing params
     * using mass assignment. Requires rules()
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $dtAdd
     * @param int $cityId
     * @return void
     */
    public static function saveModel(
        $name, $password,
        $email, $dtAdd, $cityId): void
    {
        $props = [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'dtAdd' => $dtAdd,
            'cityId' => $cityId
        ];
        $city = new self();
        $city->attributes = $props;

        $city->save();
    }
    /**
     * @param int
     * @return ActiveRecord
     */
    public static function getUser(int $id)
    {
        return self::findOne(['id' => $id]);
    }

    /** Builds one-to-one relation to City
     * accessed via magic method `city`
     * @return object City joined by id
     */
    public function getCity(): object
    {
        return $this->hasOne(City::class,
            ['id' => 'city_id']);
    }

    /**
     * Required method to make massive assignment possible
     */
    public function rules(): array
    {
        return [[[
            'email', 'name',
            'password', 'dtAdd',
            'cityId'], 'safe']
        ];
    }
}
