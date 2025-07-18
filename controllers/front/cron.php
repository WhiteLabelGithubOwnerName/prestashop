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

class WhiteLabelMachineNameCronModuleFrontController extends ModuleFrontController
{
    public $display_column_left = false;

    public $ssl = true;

    public function postProcess()
    {
        ob_end_clean();
        // Return request but keep executing
        set_time_limit(Configuration::get(WhiteLabelMachineNameBasemodule::CK_RUN_LIMIT, null, 0, 0, 0));
        ignore_user_abort(true);
        ob_start();
        if (session_id()) {
            session_write_close();
        }
        header("Content-Encoding: none");
        header("Connection: close");
        header('Content-Type: image/png');
        header("Content-Length: 0");
        ob_end_flush();
        flush();
        if (is_callable('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        $securityToken = Tools::getValue('security_token', false);
        if (! $securityToken) {
            die();
        }
        $time = new DateTime();
        WhiteLabelMachineNameHelper::startDBTransaction();
        try {
            $sqlUpdate = 'UPDATE ' . _DB_PREFIX_ . 'wlm_cron_job SET constraint_key = 0, state = "' .
                pSQL(WhiteLabelMachineNameCron::STATE_PROCESSING) . '" , date_started = "' .
                pSQL($time->format('Y-m-d H:i:s')) . '" WHERE security_token = "' . pSQL($securityToken) .
                '" AND state = "' . pSQL(WhiteLabelMachineNameCron::STATE_PENDING) . '"';

            $updateResult = DB::getInstance()->execute($sqlUpdate, false);
            if (! $updateResult) {
                $code = DB::getInstance()->getNumberError();
                if ($code == WhiteLabelMachineNameBasemodule::MYSQL_DUPLICATE_CONSTRAINT_ERROR_CODE) {
                    WhiteLabelMachineNameHelper::rollbackDBTransaction();
                    // Another Cron already running
                    die();
                } else {
                    WhiteLabelMachineNameHelper::rollbackDBTransaction();
                    PrestaShopLogger::addLog(
                        'Could not update cron job. ' . DB::getInstance()->getMsgError(),
                        2,
                        null,
                        'WhiteLabelMachineName'
                    );
                    die();
                }
            }
            if (DB::getInstance()->Affected_Rows() == 0) {
                // Simultaneous Request
                WhiteLabelMachineNameHelper::commitDBTransaction();
                die();
            }
        } catch (PrestaShopDatabaseException $e) {
            $code = DB::getInstance()->getNumberError();
            if ($code == WhiteLabelMachineNameBasemodule::MYSQL_DUPLICATE_CONSTRAINT_ERROR_CODE) {
                WhiteLabelMachineNameHelper::rollbackDBTransaction();
                // Another Cron already running
                die();
            } else {
                WhiteLabelMachineNameHelper::rollbackDBTransaction();
                PrestaShopLogger::addLog(
                    'Could not update cron job. ' . DB::getInstance()->getMsgError(),
                    2,
                    null,
                    'WhiteLabelMachineName'
                );
                die();
            }
        }
        WhiteLabelMachineNameHelper::commitDBTransaction();

        // We reduce max running time, so th cron has time to clean up.
        $maxTime = $time->format("U");
        $maxExecutionTime = WhiteLabelMachineNameHelper::getMaxExecutionTime();
        $maxTime += $maxExecutionTime == 0 ? WhiteLabelMachineNameCron::MAX_RUN_TIME_MINUTES * 60 - 60 : $maxExecutionTime;

        $tasks = Hook::exec("whiteLabelMachineNameCron", array(), null, true, false);
        $error = array();
        foreach ($tasks as $module => $subTasks) {
            foreach ($subTasks as $subTask) {
                if ($maxTime - 15 < time()) {
                    $error[] = "Cron overloaded could not execute all registered tasks.";
                    break 2;
                }
                $callableName = null;
                if (! is_callable($subTask, false, $callableName)) {
                    $error[] = "Module '$module' returns not callable task '$callableName'.";
                    continue;
                }
                try {
                    call_user_func($subTask, $maxTime);
                } catch (Exception $e) {
                    $error[] = "Module '$module' does not handle all exceptions in task '$callableName'. Exception Message: " .
                        $e->getMessage();
                }
                if ($maxTime + 15 < time()) {
                    $error[] = "Module '$module' returns not callable task '$callableName' does not respect the max runtime.";
                    break 2;
                }
            }
        }
        WhiteLabelMachineNameHelper::startDBTransaction();
        try {
            $status = WhiteLabelMachineNameCron::STATE_SUCCESS;
            $errorMessage = "";
            if (! empty($error)) {
                $status = WhiteLabelMachineNameCron::STATE_ERROR;
                $errorMessage = implode("\n", $error);
            }
            $endTime = new DateTime();
            $sqlUpdate = 'UPDATE ' . _DB_PREFIX_ . 'wlm_cron_job SET constraint_key = id_cron_job, state = "' .
                pSQL($status) . '" , date_finished = "' . pSQL($endTime->format('Y-m-d H:i:s')) . '", error_msg = "' .
                pSQL($errorMessage) . '" WHERE security_token = "' . pSQL($securityToken) . '" AND state = "' .
                pSQL(WhiteLabelMachineNameCron::STATE_PROCESSING) . '"';

            $updateResult = DB::getInstance()->execute($sqlUpdate, false);
            if (! $updateResult) {
                WhiteLabelMachineNameHelper::rollbackDBTransaction();
                PrestaShopLogger::addLog(
                    'Could not update finished cron job. ' . DB::getInstance()->getMsgError(),
                    2,
                    null,
                    'WhiteLabelMachineName'
                );
                die();
            }
            WhiteLabelMachineNameHelper::commitDBTransaction();
        } catch (PrestaShopDatabaseException $e) {
            WhiteLabelMachineNameHelper::rollbackDBTransaction();
            PrestaShopLogger::addLog(
                'Could not update finished cron job. ' . DB::getInstance()->getMsgError(),
                2,
                null,
                'WhiteLabelMachineName'
            );
            die();
        }
        WhiteLabelMachineNameCron::insertNewPendingCron();
        die();
    }

    public function setMedia()
    {
        // We do not need styling here
    }

    protected function displayMaintenancePage()
    {
        // We never display the maintenance page.
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
