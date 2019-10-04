<?php

namespace born05\commerce\buckaroo\gateways;

use Craft;
use Omnipay\Buckaroo\SepaDirectGateway as OmniPaySepaDirectGateway;

class SepaDirectDebitGateway extends BaseGateway
{
    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'SepaDirectDebit');
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName()
    {
        return '\\' . OmniPaySepaDirectGateway::class;
    }
}