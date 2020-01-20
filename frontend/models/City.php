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
        string $city, float $long, float $lat): void
    {
        $props = [
            'city' => $city,
            'long' => $long,
            'lat' => $lat
        ];
        $city = new City();
        $city->attributes = $props;

        $city->save();
    }

    public static function getCityNameList(): array
    {
        return City::findBySql('SELECT city FROM city')->
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
