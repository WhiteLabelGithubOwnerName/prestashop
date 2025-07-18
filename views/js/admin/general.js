/**
 * WhiteLabelName Prestashop
 *
 * This Prestashop module enables to process payments with WhiteLabelName (https://whitelabel-website.com).
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @copyright 2017 - 2025 customweb GmbH
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */
jQuery(function ($) {
    
    function moveWhiteLabelMachineNameManualTasks()
    {
        $("#whitelabelmachinename_notifications").find("li").each(function (key, element) {
            $("#header_infos #notification").closest("ul").append(element);
            var html = '<div class="component pull-md-right whitelabelmachinename-component"><ul>'+$(element).prop('outerHTML')+'</ul></div>';
            $('.notification-center').closest('.component').after(html);
        });
    }
    moveWhiteLabelMachineNameManualTasks();
    
});