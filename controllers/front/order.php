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

class WhiteLabelMachineNameOrderModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function postProcess()
    {
        $methodId = Tools::getValue('methodId', null);
        $cartHash = Tools::getValue('cartHash', null);
        if ($methodId == null || $cartHash == null) {
            $this->context->cookie->wlm_error = $this->module->l(
                'There was a technical issue, please try again.',
                'order'
            );
            echo json_encode(
                array(
                    'result' => 'failure',
                    'redirect' => $this->context->link->getPageLink('order', true, null)
                )
            );
            die();
        }
        $cart = $this->context->cart;
        $redirect = $this->checkAvailablility($cart);
        if (! empty($redirect)) {
            echo json_encode(array(
                'result' => 'failure',
                'redirect' => $redirect
            ));
            die();
        }

        $spaceId = Configuration::get(WhiteLabelMachineNameBasemodule::CK_SPACE_ID, null, null, $cart->id_shop);
        $methodConfiguration = new WhiteLabelMachineNameModelMethodconfiguration($methodId);
        if (! $methodConfiguration->isActive() || $methodConfiguration->getSpaceId() != $spaceId) {
            $this->context->cookie->wlm_error = $this->module->l(
                'This payment method is no longer available, please try another one.',
                'order'
            );
            echo json_encode(
                array(
                    'result' => 'failure',
                    'redirect' => $this->context->link->getPageLink('order', true, null)
                )
            );
            die();
        }
        // Ensure Fees are correct
        WhiteLabelMachineNameFeehelper::removeFeeSurchargeProductsFromCart($cart);
        WhiteLabelMachineNameFeehelper::addSurchargeProductToCart($cart);
        WhiteLabelMachineNameFeehelper::addFeeProductToCart($methodConfiguration, $cart);
        if ($cartHash != WhiteLabelMachineNameHelper::calculateCartHash($cart)) {
            $this->context->cookie->wlm_error = $this->module->l('The cart was changed, please try again.', 'order');
            echo json_encode(array(
                'result' => 'failure',
                'reload' => 'true'
            ));
            die();
        }
        $orderState = WhiteLabelMachineNameOrderstatus::getRedirectOrderStatus();
        try {
            $customer = new Customer((int) $cart->id_customer);
            $this->module->validateOrder(
                $cart->id,
                $orderState->id,
                $cart->getOrderTotal(true, Cart::BOTH, null, null, false),
                'whitelabelmachinename_' . $methodId,
                null,
                array(),
                null,
                false,
                $customer->secure_key
            );
            $noIframeParamater = Tools::getValue('whitelabelmachinename-iframe-possible-' . $methodId, null);
            $noIframe = $noIframeParamater == 'false';
            if ($noIframe) {
                $url = WhiteLabelMachineNameServiceTransaction::instance()->getPaymentPageUrl(
                    $GLOBALS['whitelabelmachinenameTransactionIds']['spaceId'],
                    $GLOBALS['whitelabelmachinenameTransactionIds']['transactionId']
                );
                echo json_encode(array(
                    'result' => 'redirect',
                    'redirect' => $url
                ));
                die();
            }
            echo json_encode(array(
                'result' => 'success'
            ));
            die();
        } catch (Exception $e) {
            $this->context->cookie->wlm_error = WhiteLabelMachineNameHelper::cleanExceptionMessage($e->getMessage());
            echo json_encode(
                array(
                    'result' => 'failure',
                    'redirect' => $this->context->link->getPageLink('order', true, null)
                )
            );
            die();
        }
    }

    /**
     * Checks if the module is still active and various checkout specfic values.
     * Returns a redirect URL where the customer has to be redirected, if there is an issue.
     *
     * @param Cart $cart
     * @return string|NULL
     */
    protected function checkAvailablility(Cart $cart)
    {
        if ($cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || ! $this->module->active ||
            ! Validate::isLoadedObject(new Customer($cart->id_customer))) {
            $this->context->cookie->wlm_error = $this->module->l('Your session expired, please try again.', 'order');
            return $this->context->link->getPageLink('order', true, null, "step=1");
        }
        // Check that this payment option is still available in case the customer changed his address just before the
        // end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'whitelabelmachinename') {
                $authorized = true;
                break;
            }
        }
        if (! $authorized) {
            $this->context->cookie->wlm_error = $this->module->l(
                'This payment method is no longer available, please try another one.',
                'order'
            );
            return $this->context->link->getPageLink('order', true, null);
        }

        if (! $this->module instanceof WhiteLabelMachineName) {
            $this->context->cookie->wlm_error = $this->module->l(
                'There was a technical issue, please try again.',
                'order'
            );
            return $this->context->link->getPageLink('order', true, null);
        }
        return null;
    }

    public function setMedia()
    {
        // We do not need styling here
    }

    protected function displayMaintenancePage()
    {
        // We want never to see here the maintenance page.
    }

    protected function displayRestrictedCountryPage()
    {
        // We do not want to restrict the content by any country.
    }

    protected function canonicalRedirection($canonical_url = '')
    {
        // We do not need any canonical redirect
    }
}
