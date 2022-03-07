<?php

namespace born05\commerce\buckaroo;

use born05\commerce\buckaroo\gateways\CreditCardGateway;
use born05\commerce\buckaroo\gateways\IdealGateway;
use born05\commerce\buckaroo\gateways\PayPalGateway;
use born05\commerce\buckaroo\gateways\SepaDirectDebitGateway;
use born05\commerce\buckaroo\models\Settings;

use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;
use yii\base\Event;

class Plugin extends \craft\base\Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Plugin::$plugin
     *
     * @var Plugin
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(Gateways::class, Gateways::EVENT_REGISTER_GATEWAY_TYPES,  function(RegisterComponentTypesEvent $event) {
            $event->types[] = CreditCardGateway::class;
            $event->types[] = IdealGateway::class;
            $event->types[] = PayPalGateway::class;
            $event->types[] = SepaDirectDebitGateway::class;
        });
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }
}
