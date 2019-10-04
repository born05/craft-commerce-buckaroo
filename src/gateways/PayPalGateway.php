<?php

namespace born05\commerce\buckaroo\gateways;

use born05\commerce\buckaroo\base\Gateway;

use Craft;
use Omnipay\Buckaroo\PayPalGateway as OmniPayPayPalGateway;

class PayPalGateway extends Gateway
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'Buckaroo PayPal');
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName()
    {
        return '\\' . OmniPayPayPalGateway::class;
    }
}