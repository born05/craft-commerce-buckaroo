<?php

namespace born05\commerce\buckaroo\models;

use craft\base\Model;

class Settings extends Model
{
    /**
     * Allow a totp delay in seconds (gives the user some extra time after code expired)
     *
     * @var boolean
     */
    public $testMode = null;
}
