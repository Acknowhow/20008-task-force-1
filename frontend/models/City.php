<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{
    /** Saves or updates existing table
     * @param string $city
     * @param float $long
     * @param float $lat
     * @return void
     */
    public static function saveModel(
        $city, $long, $lat): void
    {
        $props = [
            'city' => $city,
            'long' => $long,
            'lat' => $lat
        ];
        $city = new self();
        $city->attributes = $props;

        $city->save();
    }

    /**
     * @param int
     * @return ActiveRecord
     */
    public static function getCity(int $id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function getCityNameList(): array
    {
        return self::findBySql('SELECT city FROM city')->
        asArray()->all();
    }
    /**
     * Required method to make massive assignment possible
     * @return array of rules
     */
    public function rules(): array
    {
        return [
            [['city', 'long', 'lat'], 'safe']
        ];

    }
}
