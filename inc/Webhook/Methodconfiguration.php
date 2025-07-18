<?php
/**
 * WhiteLabelName Prestashop
 *
 * This Prestashop module enables to process payments with WhiteLabelName (https://whitelabel-website.com).
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @copyright 2017 - 2025 customweb GmbH
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

/**
 * Webhook processor to handle payment method configuration state transitions.
 */
class WhiteLabelMachineNameWebhookMethodconfiguration extends WhiteLabelMachineNameWebhookAbstract
{

    /**
     * Synchronizes the payment method configurations on state transition.
     *
     * @param WhiteLabelMachineNameWebhookRequest $request
     */
    public function process(WhiteLabelMachineNameWebhookRequest $request)
    {
        $paymentMethodConfigurationService = WhiteLabelMachineNameServiceMethodconfiguration::instance();
        $paymentMethodConfigurationService->synchronize();
    }
}
