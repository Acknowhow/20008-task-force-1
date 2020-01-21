<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{
    public static function actionList()
    {
        return City::findBySql('SELECT city FROM city')->
        asArray()->all();
    }
}
