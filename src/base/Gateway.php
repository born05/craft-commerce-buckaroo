<?php

namespace born05\commerce\buckaroo\base;

use born05\commerce\buckaroo\Plugin as BuckarooPlugin;

use Craft;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\omnipay\base\OffsiteGateway;

use Omnipay\Common\AbstractGateway;
use Omnipay\Buckaroo\BuckarooGateway as OmnipayBuckarooGateway;

abstract class Gateway extends OffsiteGateway
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
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('commerce-buckaroo/gatewaySettings', ['gateway' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function populateRequest(array &$request, BasePaymentForm $paymentForm = null): void
    {
        $request['culture'] = Craft::$app->language;
    }

    /**
     * @inheritdoc
     */
    public function supportsWebhooks(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getPaymentTypeOptions(): array
    {
        return [
            'purchase' => Craft::t('commerce', 'Purchase (Authorize and Capture Immediately)')
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineRules(): array
    {
        $rules = parent::defineRules();
        $rules[] = ['paymentType', 'compare', 'compareValue' => 'purchase'];

        return $rules;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createGateway(): AbstractGateway
    {
        /** @var OmnipayBuckarooGateway $gateway */
        $gateway = static::createOmnipayGateway($this->getGatewayClassName());

        $settings = BuckarooPlugin::$plugin->getSettings();
        $testMode = $settings->testMode !== null ? $settings->testMode : $this->testMode;

        $gateway->setWebsiteKey(Craft::parseEnv($this->websiteKey));
        $gateway->setSecretKey(Craft::parseEnv($this->secretKey));
        $gateway->setTestMode($testMode);

        return $gateway;
    }
}
