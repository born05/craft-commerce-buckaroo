<?php

namespace born05\commerce\buckaroo\models\forms;

use craft\commerce\models\payments\OffsitePaymentForm;

class IdealPaymentForm extends OffsitePaymentForm
{
    /**
     * @var string|null
     */
    public ?string $issuer = null;
}