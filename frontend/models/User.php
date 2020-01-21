<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /** Saves or updates existing table
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $dtAdd
     * @param int $cityId
     * @return void
     */
    public static function saveModel(
        string $name, string $password,
        string $email, string $dtAdd, int $cityId): void
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
    /** Gets user model by id
     * @param int userId
     * @return object User
     */
    public static function getUser(int $id): object
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
