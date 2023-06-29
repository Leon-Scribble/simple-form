<?php

namespace scribblewerbeagentur\craftsimpleform\models;

use Craft;
use craft\base\Model;

/**
 * SimpleForm settings
 */
class Settings extends Model
{
    public $foo = 'defaultFooValue';
    public $bar = 'defaultBarValue';
    public function defineRules(): array
    {
        return [
            [['foo', 'bar'], 'required'],
        ];
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

}
