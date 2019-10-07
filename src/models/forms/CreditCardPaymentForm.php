<?php

namespace born05\commerce\buckaroo\models\forms;

use craft\commerce\models\payments\OffsitePaymentForm;

class CreditCardPaymentForm extends OffsitePaymentForm
{
    public $paymentMethod;
}