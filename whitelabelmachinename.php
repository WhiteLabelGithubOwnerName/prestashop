<?php

/**
 * WhiteLabelName Prestashop
 *
 * This Prestashop module enables to process payments with WhiteLabelName (https://whitelabel-website.com).
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @copyright 2017 - 2026 customweb GmbH
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit();
}

use PrestaShop\PrestaShop\Core\Domain\Order\CancellationActionType;

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'whitelabelmachinename_autoloader.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'whitelabelmachinename-sdk' . DIRECTORY_SEPARATOR .
    'autoload.php');
class WhiteLabelMachineName extends PaymentModule
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->name = 'whitelabelmachinename';
        $this->tab = 'payments_gateways';
        $this->author = 'wallee AG';
        $this->bootstrap = true;
        $this->need_instance = 0;
        $this->version = '2.0.7';
        $this->displayName = 'WhiteLabelName';
        $this->description = $this->l('This PrestaShop module enables to process payments with %s.');
        $this->description = sprintf($this->description, 'WhiteLabelName');
        $this->module_key = 'PrestaShop_ProductKey_V8';
        $this->ps_versions_compliancy = array(
            'min' => '8',
            'max' => _PS_VERSION_
        );
        parent::__construct();
        $this->confirmUninstall = sprintf(
            $this->l('Are you sure you want to uninstall the %s module?', 'abstractmodule'),
            'WhiteLabelName'
        );

        // Remove Fee Item
        if (isset($this->context->cart) && Validate::isLoadedObject($this->context->cart)) {
            WhiteLabelMachineNameFeehelper::removeFeeSurchargeProductsFromCart($this->context->cart);
        }
        if (!empty($this->context->cookie->wlm_error)) {
            $errors = $this->context->cookie->wlm_error;
            if (is_string($errors)) {
                $this->context->controller->errors[] = $errors;
            } elseif (is_array($errors)) {
                foreach ($errors as $error) {
                    $this->context->controller->errors[] = $error;
                }
            }
            unset($_SERVER['HTTP_REFERER']); // To disable the back button in the error message
            $this->context->cookie->wlm_error = null;
        }
    }

    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function install()
    {
        if (!WhiteLabelMachineNameBasemodule::checkRequirements($this)) {
            return false;
        }
        if (!parent::install()) {
            return false;
        }
        return WhiteLabelMachineNameBasemodule::install($this);
    }

    public function uninstall()
    {
        return parent::uninstall() && WhiteLabelMachineNameBasemodule::uninstall($this);
    }

    public function upgrade($version)
    {
        return true;
    }

    public function installHooks()
    {
        return WhiteLabelMachineNameBasemodule::installHooks($this) && $this->registerHook('paymentOptions') &&
            $this->registerHook('actionFrontControllerSetMedia') &&
            $this->registerHook('actionValidateStepComplete') &&
            $this->registerHook('actionObjectAddressAddAfter');
    }

    public function getBackendControllers()
    {
        return array(
            'AdminWhiteLabelMachineNameMethodSettings' => array(
                'parentId' => Tab::getIdFromClassName('AdminParentPayment'),
                'name' => 'WhiteLabelName ' . $this->l('Payment Methods')
            ),
            'AdminWhiteLabelMachineNameDocuments' => array(
                'parentId' => -1, // No Tab in navigation
                'name' => 'WhiteLabelName ' . $this->l('Documents')
            ),
            'AdminWhiteLabelMachineNameOrder' => array(
                'parentId' => -1, // No Tab in navigation
                'name' => 'WhiteLabelName ' . $this->l('Order Management')
            )
        );
    }

    public function installConfigurationValues()
    {
        return WhiteLabelMachineNameBasemodule::installConfigurationValues();
    }

    public function uninstallConfigurationValues()
    {
        return WhiteLabelMachineNameBasemodule::uninstallConfigurationValues();
    }

    public function getContent()
    {
        $output = WhiteLabelMachineNameBasemodule::handleSaveAll($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveApplication($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveEmail($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveIntegration($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveCartRecreation($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveFeeItem($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveDownload($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveSpaceViewId($this);
        $output .= WhiteLabelMachineNameBasemodule::handleSaveOrderStatus($this);
        $output .= WhiteLabelMachineNameBasemodule::displayHelpButtons($this);
        return $output . WhiteLabelMachineNameBasemodule::displayForm($this);
    }

    public function getConfigurationForms()
    {
        return array(
            WhiteLabelMachineNameBasemodule::getEmailForm($this),
            WhiteLabelMachineNameBasemodule::getIntegrationForm($this),
            WhiteLabelMachineNameBasemodule::getCartRecreationForm($this),
            WhiteLabelMachineNameBasemodule::getFeeForm($this),
            WhiteLabelMachineNameBasemodule::getDocumentForm($this),
            WhiteLabelMachineNameBasemodule::getSpaceViewIdForm($this),
            WhiteLabelMachineNameBasemodule::getOrderStatusForm($this)
        );
    }

    public function getConfigurationValues()
    {
        return array_merge(
            WhiteLabelMachineNameBasemodule::getApplicationConfigValues($this),
            WhiteLabelMachineNameBasemodule::getEmailConfigValues($this),
            WhiteLabelMachineNameBasemodule::getIntegrationConfigValues($this),
            WhiteLabelMachineNameBasemodule::getCartRecreationConfigValues($this),
            WhiteLabelMachineNameBasemodule::getFeeItemConfigValues($this),
            WhiteLabelMachineNameBasemodule::getDownloadConfigValues($this),
            WhiteLabelMachineNameBasemodule::getSpaceViewIdConfigValues($this),
            WhiteLabelMachineNameBasemodule::getOrderStatusConfigValues($this)
        );
    }

    public function getConfigurationKeys()
    {
        return WhiteLabelMachineNameBasemodule::getConfigurationKeys();
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }
        if (!isset($params['cart']) || !($params['cart'] instanceof Cart)) {
            return;
        }
        $cart = $params['cart'];
        try {
            $transactionService = WhiteLabelMachineNameServiceTransaction::instance();
            $transaction = $transactionService->getTransactionFromCart($cart);
            $possiblePaymentMethods = $transactionService->getPossiblePaymentMethods($cart, $transaction);
        } catch (WhiteLabelMachineNameExceptionInvalidtransactionamount $e) {
            PrestaShopLogger::addLog($e->getMessage() . " CartId: " . $cart->id, 2, null, 'WhiteLabelMachineName');
            $paymentOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $paymentOption->setCallToActionText(
                $this->l('There is an issue with your cart, some payment methods are not available.')
            );
            $paymentOption->setAdditionalInformation(
                $this->context->smarty->fetch(
                    'module:whitelabelmachinename/views/templates/front/hook/amount_error.tpl'
                )
            );
            $paymentOption->setForm(
                $this->context->smarty->fetch(
                    'module:whitelabelmachinename/views/templates/front/hook/amount_error_form.tpl'
                )
            );
            $paymentOption->setModuleName($this->name . "-error");
            return array(
                $paymentOption
            );
        } catch (Exception $e) {
            PrestaShopLogger::addLog($e->getMessage() . " CartId: " . $cart->id, 1, null, 'WhiteLabelMachineName');
            return array();
        }
        $shopId = $cart->id_shop;
        $language = Context::getContext()->language->language_code;
        $methods = $this->filterShopMethodConfigurations($shopId, $possiblePaymentMethods);
        $result = array();

        $this->context->smarty->registerPlugin(
            'function',
            'whitelabelmachinename_clean_html',
            array(
                'WhiteLabelMachineNameSmartyfunctions',
                'cleanHtml'
            )
        );

        foreach (WhiteLabelMachineNameHelper::sortMethodConfiguration($methods) as $methodConfiguration) {
            $parameters = WhiteLabelMachineNameBasemodule::getParametersFromMethodConfiguration($this, $methodConfiguration, $cart, $shopId, $language);
            $parameters['priceDisplayTax'] = Group::getPriceDisplayMethod(Group::getCurrent()->id);
            $parameters['orderUrl'] = $this->context->link->getModuleLink(
                'whitelabelmachinename',
                'order',
                array(),
                true
            );
            $this->context->smarty->assign($parameters);
            $paymentOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $paymentOption->setCallToActionText($parameters['name']);
            $paymentOption->setLogo($parameters['image']);
            $paymentOption->setAction($parameters['link']);
            $paymentOption->setAdditionalInformation(
                $this->context->smarty->fetch(
                    'module:whitelabelmachinename/views/templates/front/hook/payment_additional.tpl'
                )
            );
            $paymentOption->setForm(
                $this->context->smarty->fetch(
                    'module:whitelabelmachinename/views/templates/front/hook/payment_form.tpl'
                )
            );
            $paymentOption->setModuleName($this->name);
            $result[] = $paymentOption;
        }
        return $result;
    }

    /**
     * Filters configured method entities for the current shop and the available SDK payment methods.
     *
     * @param int $shopId
     * @param \WhiteLabelMachineName\Sdk\Model\PaymentMethodConfiguration[] $possiblePaymentMethods
     * @return WhiteLabelMachineNameModelMethodconfiguration[]
     */
    protected function filterShopMethodConfigurations($shopId, array $possiblePaymentMethods)
    {
        $configured = WhiteLabelMachineNameModelMethodconfiguration::loadValidForShop($shopId);
        if (empty($configured) || empty($possiblePaymentMethods)) {
            return array();
        }

        $bySpaceAndConfiguration = array();
        foreach ($configured as $methodConfiguration) {
            $spaceId = $methodConfiguration->getSpaceId();
            if (! isset($bySpaceAndConfiguration[$spaceId])) {
                $bySpaceAndConfiguration[$spaceId] = array();
            }
            $bySpaceAndConfiguration[$spaceId][$methodConfiguration->getConfigurationId()] = $methodConfiguration;
        }

        $result = array();
        foreach ($possiblePaymentMethods as $possible) {
            $spaceId = $possible->getSpaceId();
            $configurationId = $possible->getId();
            if (isset($bySpaceAndConfiguration[$spaceId][$configurationId])) {
                $methodConfiguration = $bySpaceAndConfiguration[$spaceId][$configurationId];
                if ($methodConfiguration->isActive()) {
                    $result[] = $methodConfiguration;
                }
            }
        }

        return $result;
    }

    public function hookActionFrontControllerSetMedia()
    {
        $controller = $this->context->controller;

        if (!$controller) {
            return;
        }

        $phpSelf = $controller->php_self;
        if ($phpSelf === 'order' || $phpSelf === 'cart') {

            // Ensure device ID exists
            if (empty($this->context->cookie->wlm_device_id)) {
                $this->context->cookie->wlm_device_id = WhiteLabelMachineNameHelper::generateUUID();
            }

            $deviceId = $this->context->cookie->wlm_device_id;

            $scriptUrl = WhiteLabelMachineNameHelper::getBaseGatewayUrl() .
                '/s/' . Configuration::get(WhiteLabelMachineNameBasemodule::CK_SPACE_ID) .
                '/payment/device.js?sessionIdentifier=' . $deviceId;

            $controller->registerJavascript(
                'whitelabelmachinename-device-identifier',
                $scriptUrl,
                [
                'server' => 'remote',
                'attributes' => 'async'
                ]
            );
        }

        /**
         * ORDER PAGE ONLY
         * Add checkout JS/CSS + iframe handler
         */
        if ($phpSelf === 'order') {

            // checkout styles
            $controller->registerStylesheet(
                'whitelabelmachinename-checkout-css',
                'modules/' . $this->name . '/views/css/frontend/checkout.css'
            );

            // checkout JS
            $controller->registerJavascript(
                'whitelabelmachinename-checkout-js',
                'modules/' . $this->name . '/views/js/frontend/checkout.js'
            );

            // define global JS variables
            Media::addJsDef([
                'whiteLabelMachineNameCheckoutUrl' => $this->context->link->getModuleLink(
                'whitelabelmachinename',
                'checkout',
                [],
                true
                ),
                'whitelabelmachinenameMsgJsonError' => $this->l(
                'The server experienced an unexpected error, you may try again or try a different payment method.'
                )
            ]);

            // Iframe handler JS (only when integration = iframe)
            $cart = $this->context->cart;

            if ($cart && Validate::isLoadedObject($cart)) {
                try {
                    // Get integration type from configuration
                    // 0 = iframe
                    // 1 = payment page
                    $integrationType = (int) Configuration::get(WhiteLabelMachineNameBasemodule::CK_INTEGRATION);

                    // Only load JS when NOT payment page
                    if ($integrationType !== Configuration::get(WhiteLabelMachineNameBasemodule::CK_INTEGRATION_TYPE_PAYMENT_PAGE)) {

                        $jsUrl = WhiteLabelMachineNameServiceTransaction::instance()
                            ->getJavascriptUrl($cart);

                        $this->context->controller->registerJavascript(
                            'whitelabelmachinename-iframe-handler',
                            $jsUrl,
                            [
                            'server' => 'remote',
                            'priority' => 45,
                            'attributes' => 'id="whitelabelmachinename-iframe-handler"'
                            ]
                        );
                    }

                } catch (Exception $e) {
                    // same behavior: silently ignore
                }
            }
        }

        /**
         * ORDER-DETAIL PAGE
         */
        if ($phpSelf === 'order-detail') {
            $controller->registerJavascript(
                'whitelabelmachinename-orderdetail-js',
                'modules/' . $this->name . '/views/js/frontend/orderdetail.js'
            );
        }
    }

    public function hookActionObjectAddressAddAfter($params)
    {
        $this->processAddressChange(isset($params['object']) ? $params['object'] : null);
    }

    public function hookActionValidateStepComplete($params)
    {
        if (isset($params['step_name']) && $params['step_name'] === 'addresses') {
            $this->processAddressChange(null);
        }
    }

    /**
     * Refreshes the pending transaction when the checkout address is created/selected.
     *
     * @param Address|null $address
     */
    private function processAddressChange($address = null)
    {
        $cart = $this->context->cart;
        if (!$cart || !Validate::isLoadedObject($cart)) {
            return;
        }

        try {
            WhiteLabelMachineNameServiceTransaction::instance()->refreshTransactionFromCart($cart);
        } catch (Exception $e) {
            PrestaShopLogger::addLog(
                'WhiteLabelMachineName address refresh failed: ' . $e->getMessage(),
                2,
                null,
                $this->name
            );
        }
    }


    public function hookActionAdminControllerSetMedia($arr)
    {
        WhiteLabelMachineNameBasemodule::hookActionAdminControllerSetMedia($this, $arr);
        $this->context->controller->addCSS(__PS_BASE_URI__ . 'modules/' . $this->name . '/views/css/admin/general.css');
    }

    public function hasBackendControllerDeleteAccess(AdminController $backendController)
    {
        return $backendController->access('delete');
    }

    public function hasBackendControllerEditAccess(AdminController $backendController)
    {
        return $backendController->access('edit');
    }

    /**
     * Show the manual task in the admin bar.
     * The output is moved with javascript to the correct place as better hook is missing.
     *
     * @return string
     */
    public function hookDisplayAdminAfterHeader()
    {
        $result = WhiteLabelMachineNameBasemodule::hookDisplayAdminAfterHeader($this);
        return $result;
    }

    public function hookWhiteLabelMachineNameSettingsChanged($params)
    {
        return WhiteLabelMachineNameBasemodule::hookWhiteLabelMachineNameSettingsChanged($this, $params);
    }

    public function hookActionMailSend($data)
    {
        return WhiteLabelMachineNameBasemodule::hookActionMailSend($this, $data);
    }

    public function validateOrder(
        $id_cart,
        $id_order_state,
        $amount_paid,
        $payment_method = 'Unknown',
        $message = null,
        $extra_vars = array(),
        $currency_special = null,
        $dont_touch_amount = false,
        $secure_key = false,
        Shop $shop = null,
        $order_reference = null
    ) {
        WhiteLabelMachineNameBasemodule::validateOrder($this, $id_cart, $id_order_state, $amount_paid, $payment_method, $message, $extra_vars, $currency_special, $dont_touch_amount, $secure_key, $shop, $order_reference);
    }

    public function validateOrderParent(
        $id_cart,
        $id_order_state,
        $amount_paid,
        $payment_method = 'Unknown',
        $message = null,
        $extra_vars = array(),
        $currency_special = null,
        $dont_touch_amount = false,
        $secure_key = false,
        Shop $shop = null,
        $order_reference = null
    ) {
        parent::validateOrder($id_cart, $id_order_state, $amount_paid, $payment_method, $message, $extra_vars, $currency_special, $dont_touch_amount, $secure_key, $shop, $order_reference);
    }

    public function hookDisplayOrderDetail($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayOrderDetail($this, $params);
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        WhiteLabelMachineNameBasemodule::hookDisplayBackOfficeHeader($this, $params);
    }

    public function hookDisplayAdminOrderLeft($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderLeft($this, $params);
    }

    public function hookDisplayAdminOrderTabOrder($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderTabOrder($this, $params);
    }

    public function hookDisplayAdminOrderMain($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderMain($this, $params);
    }

    public function hookActionOrderSlipAdd($params)
    {
        $refundParameters = Tools::getAllValues();

        $order = $params['order'];

        if (!Validate::isLoadedObject($order) || $order->module != $this->name) {
            $idOrder = Tools::getValue('id_order');
            if (!$idOrder) {
                $order = $params['order'];
                $idOrder = (int)$order->id;
            }
            $order = new Order((int) $idOrder);
            if (! Validate::isLoadedObject($order) || $order->module != $module->name) {
                return;
            }
        }

        $strategy = WhiteLabelMachineNameBackendStrategyprovider::getStrategy();

        if ($strategy->isVoucherOnlyWhiteLabelMachineName($order, $refundParameters)) {
            return;
        }

        // need to manually set this here as it's expected downstream
        $refundParameters['partialRefund'] = true;

        $backendController = Context::getContext()->controller;
        $editAccess = 0;

        $access = Profile::getProfileAccess(
            Context::getContext()->employee->id_profile,
            (int) Tab::getIdFromClassName('AdminOrders')
        );
        $editAccess = isset($access['edit']) && $access['edit'] == 1;

        if ($editAccess) {
            try {
                $parsedData = $strategy->simplifiedRefund($refundParameters);
                WhiteLabelMachineNameServiceRefund::instance()->executeRefund($order, $parsedData);
            } catch (Exception $e) {
                $backendController->errors[] = WhiteLabelMachineNameHelper::cleanExceptionMessage($e->getMessage());
            }
        } else {
            $backendController->errors[] = Tools::displayError('You do not have permission to delete this.');
        }
    }

    public function hookDisplayAdminOrderTabLink($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderTabLink($this, $params);
    }

    public function hookDisplayAdminOrderContentOrder($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderContentOrder($this, $params);
    }

    public function hookDisplayAdminOrderTabContent($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrderTabContent($this, $params);
    }

    public function hookDisplayAdminOrder($params)
    {
        return WhiteLabelMachineNameBasemodule::hookDisplayAdminOrder($this, $params);
    }

    public function hookActionAdminOrdersControllerBefore($params)
    {
        return WhiteLabelMachineNameBasemodule::hookActionAdminOrdersControllerBefore($this, $params);
    }

    public function hookActionObjectOrderPaymentAddBefore($params)
    {
        WhiteLabelMachineNameBasemodule::hookActionObjectOrderPaymentAddBefore($this, $params);
    }

    public function hookActionOrderEdited($params)
    {
        WhiteLabelMachineNameBasemodule::hookActionOrderEdited($this, $params);
    }

    public function hookActionOrderGridDefinitionModifier($params)
    {
        WhiteLabelMachineNameBasemodule::hookActionOrderGridDefinitionModifier($this, $params);
    }

    public function hookActionOrderGridQueryBuilderModifier($params)
    {
        WhiteLabelMachineNameBasemodule::hookActionOrderGridQueryBuilderModifier($this, $params);
    }

    public function hookActionProductCancel($params)
    {
        if ($params['action'] === CancellationActionType::PARTIAL_REFUND) {
            $idOrder = Tools::getValue('id_order');
            $refundParameters = Tools::getAllValues();

            $order = $params['order'];

            if (!Validate::isLoadedObject($order) || $order->module != $this->name) {
                return;
            }

            $strategy = WhiteLabelMachineNameBackendStrategyprovider::getStrategy();
            if ($strategy->isVoucherOnlyWhiteLabelMachineName($order, $refundParameters)) {
                return;
            }

            // need to manually set this here as it's expected downstream
            $refundParameters['partialRefund'] = true;

            $backendController = Context::getContext()->controller;
            $editAccess = 0;

            $access = Profile::getProfileAccess(
                Context::getContext()->employee->id_profile,
                (int) Tab::getIdFromClassName('AdminOrders')
            );
            $editAccess = isset($access['edit']) && $access['edit'] == 1;

            if ($editAccess) {
                try {
                    $parsedData = $strategy->simplifiedRefund($refundParameters);
                    WhiteLabelMachineNameServiceRefund::instance()->executeRefund($order, $parsedData);
                } catch (Exception $e) {
                    $backendController->errors[] = WhiteLabelMachineNameHelper::cleanExceptionMessage($e->getMessage());
                }
            } else {
                $backendController->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
        }
    }
}
