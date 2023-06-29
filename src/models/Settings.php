<?php

namespace scribblewerbeagentur\craftsimpleform\models;

use Craft;
use craft\base\Model;

/**
 * SimpleForm settings
 */
class Settings extends Model
{
    public $receiver = 'example@example.com';
    public $subject = '[SimpleForm] Default';

    public $data = [

    ];

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

}
