<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{
    public static function getAllCities()
    {
        return City::find()->all();
    }
}
