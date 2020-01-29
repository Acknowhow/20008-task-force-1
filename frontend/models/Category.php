<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public function saveCategoryRecord(
        $name, $icon): void
    {
        $props = [
          'name' => $name,
          'icon' => $icon
        ];

        $category = new self();
        $category->attributes = $props;

        $category->save();
    }

    /**
     * @param int
     * @return ActiveRecord
     */
    public static function getCity(int $id)
    {
        return self::findOne(['id' => $id]);
    }

    public function findAllNames()
    {
        $contacts = self::findAll(['name' => 'Дудеть']);
        foreach ($contacts as $contact) {
            print($contact->name);
        }
    }

    /**
     * Required method to make massive assignment possible
     * @return array of rules
     */
    public function rules(): array
    {
        return [
            [['name', 'icon'], 'safe']
        ];
    }
}
