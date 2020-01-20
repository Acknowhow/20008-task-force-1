<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public function saveCategoryRecord(string $name, string $icon): void
    {
        $props = [
          'name' => $name,
          'icon' => $icon
        ];

        $category = new Category();
        $category->attributes = $props;

        $category->save();
    }

    public function findAllNames()
    {
        $contacts = Category::findAll(['name' => 'Дудеть']);
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
