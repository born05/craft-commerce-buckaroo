<?php

namespace born05\commerce\buckaroo\gateways;

use born05\commerce\buckaroo\base\Gateway;
use born05\commerce\buckaroo\models\forms\CreditCardPaymentForm;

use Craft;
use craft\commerce\models\payments\BasePaymentForm;
use craft\web\View;
use Omnipay\Buckaroo\CreditCardGateway as OmniPayCreditCardGateway;

class CreditCardGateway extends Gateway
{
    // Properties
    // =========================================================================

    /**
     * @var string|null
     */
    public ?string $websiteKey = "";

    /**
     * @var string|null
     */
    public ?string $secretKey = "";

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
        return Craft::t('commerce', 'Buckaroo CreditCard');
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new CreditCardPaymentForm();
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormHtml(array $params): null|string
    {
        try {
            $defaults = [
                'gateway' => $this,
                'paymentForm' => $this->getPaymentFormModel(),
                'paymentMethods' => $this->fetchPaymentMethods(),
            ];
        } catch (\Throwable $exception) {
            // In case this is not allowed for the account
            return parent::getPaymentFormHtml($params);
        }

        $params = array_merge($defaults, $params);

        $view = Craft::$app->getView();

        $previousMode = $view->getTemplateMode();
        $view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $html = $view->renderTemplate('commerce-buckaroo/creditCardPaymentForm', $params);
        $view->setTemplateMode($previousMode);

        return $html;
    }

    /**
     * @inheritdoc
     */
    public function populateRequest(array &$request, BasePaymentForm $paymentForm = null): void
    {
        parent::populateRequest($request, $paymentForm);

        if ($paymentForm) {
            /** @var CreditCardPaymentForm $paymentForm */
            if ($paymentForm->paymentMethod) {
                $request['paymentMethod'] = $paymentForm->paymentMethod;
            }
        }
    }

    /**
     * @return mixed
     */
    public function fetchPaymentMethods(): array
    {
        // Source: https://dev.buckaroo.nl/PaymentMethods/Description/creditcards
        return [
            // Creditcards
            'mastercard' => 'MasterCard',
            'visa' => 'Visa',
            'amex' => 'American Express',

            // // Debit cards
            // 'vpay' => 'VPay',
            // 'maestro' => 'Maestro',
            // 'visaelectron' => 'Visa Electron',
            // 'cartebleuevisa' => 'Carte Bleue',
            // 'cartebancaire' => 'Carte Bancaire',
            // 'dankort' => 'Dankort',
            // 'nexi' => 'Nexi',
        ];
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName(): ?string
    {
        return '\\' . OmniPayCreditCardGateway::class;
    }
}