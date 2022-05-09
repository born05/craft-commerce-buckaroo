<?php

namespace born05\commerce\buckaroo\gateways;

use born05\commerce\buckaroo\base\Gateway;

use Craft;
use Omnipay\Buckaroo\SepaDirectDebitGateway as OmniPaySepaDirectDebitGateway;

class SepaDirectDebitGateway extends Gateway
{
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    public $websiteKey;

    /**
     * @var string
     */
    public $secretKey;

    /**
     * @var bool
     */
    public $testMode = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'Buckaroo SepaDirectDebit');
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName(): null|string
    {
        return '\\' . OmniPaySepaDirectDebitGateway::class;
    }
}