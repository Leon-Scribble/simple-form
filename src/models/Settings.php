<?php

namespace scribblewerbeagentur\craftsimpleform\models;

use Craft;
use craft\base\Model;

/**
 * SimpleForm settings
 */
class Settings extends Model
{
    public string $receiver = 'example@example.com';
    public string $subject = '[SimpleForm] Default';
    public bool $overrideCopyEmail = false;

    public $data = [

    ];

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

}
