<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class Task_copy extends ActiveRecord
{
    /** Saves or updates existing table
     * @param string $dtAdd
     * @param int $categoryId
     * @param string $description
     * @param string $expire
     * @param string $name
     * @param string $address
     * @param int $budget
     * @param float $lat
     * @param float $long
     * @param int $clientId
     * @param int $contractorId
     * @return void
     */

    public static function saveModel(
        string $dtAdd, int $categoryId,
        string $description, string $expire,

        string $name, string $address,
        int $budget, float $lat, float $long,
        int $clientId, int $contractorId): void
    {
        $props = [
            'dtAdd' => $dtAdd,
            'categoryId' => $categoryId,
            'description' => $description,
            'expire' => $expire,
            'name' => $name,
            'address' => $address,
            'budget' => $budget,
            'lat' => $lat,
            'long' => $long,
            'clientId' => $clientId,
            'contractorId' => $contractorId
        ];
        $city = new self();
        $city->attributes = $props;

        $city->save();
    }

    /** Gets user model by id
     * @param int userId
     * @return object User
     */
    public static function getTask(int $id): object
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
