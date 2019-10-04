<?php

namespace born05\commerce\buckaroo\gateways;

use Craft;
use Omnipay\Buckaroo\PayPalGateway as OmniPayPayPalGateway;

class PayPalGateway extends BaseGateway
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'PayPal');
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