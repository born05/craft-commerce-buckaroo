<?php

namespace born05\commerce\buckaroo\gateways;

use born05\commerce\buckaroo\base\Gateway;

use Craft;
use Omnipay\Buckaroo\PayPalGateway as OmniPayPayPalGateway;

class PayPalGateway extends Gateway
{
    // Properties
    // =========================================================================

    /**
     * @var string|null
     */
    public ?string $websiteKey;

    /**
     * @var string|null
     */
    public ?string $secretKey;

    /**
     * @var bool|null
     */
    public ?bool $testMode = false;

    // Public Methods
    // =========================================================================

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
    protected function getGatewayClassName(): ?string
    {
        return '\\' . OmniPayPayPalGateway::class;
    }
}