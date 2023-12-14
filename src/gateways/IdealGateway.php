<?php

namespace born05\commerce\buckaroo\gateways;

use born05\commerce\buckaroo\base\Gateway;
use born05\commerce\buckaroo\models\forms\IdealPaymentForm;

use Craft;
use craft\commerce\models\payments\BasePaymentForm;
use craft\web\View;
use Omnipay\Buckaroo\IdealGateway as OmniPayIdealGateway;

class IdealGateway extends Gateway
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
        return Craft::t('commerce', 'Buckaroo Ideal');
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new IdealPaymentForm();
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
                'issuers' => $this->fetchIssuers(),
            ];
        } catch (\Throwable $exception) {
            // In case this is not allowed for the account
            return parent::getPaymentFormHtml($params);
        }

        $params = array_merge($defaults, $params);

        $view = Craft::$app->getView();

        $previousMode = $view->getTemplateMode();
        $view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $html = $view->renderTemplate('commerce-buckaroo/idealPaymentForm', $params);
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
            /** @var IdealPaymentForm $paymentForm */
            if ($paymentForm->issuer) {
                $request['issuer'] = $paymentForm->issuer;
            }
        }
    }

    /**
     * @return mixed
     */
    public function fetchIssuers(): array
    {
        // Source: https://docs.buckaroo.io/docs/nl/ideal-integration
        return [
            'ABNANL2A' => 'ABN AMRO',
            'ASNBNL21' => 'ASN Bank',
            'BUNQNL2A' => 'Bunq',
            'INGBNL2A' => 'ING',
            'KNABNL2H' => 'Knab',
            'RABONL2U' => 'Rabobank',
            'REVOLT21' => 'Revolut',
            'SNSBNL2A' => 'SNS Bank',
            'RBRBNL21' => 'SNS Regio Bank',
            'TRIONL2U' => 'Triodos Bank',
            'FVLBNL22' => 'Van Lanschot',
            'BITSNL2A' => 'YourSafe',
        ];
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName(): ?string
    {
        return '\\' . OmniPayIdealGateway::class;
    }
}