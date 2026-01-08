<?php
/**
 * Class Webhooksignature
 *
 * This class is responsible for fetching webhook listeners and ensuring that
 * payload signature and state are enabled for active webhook listeners.
 *
 * The `run` method iterates through all shops, retrieves the active webhook listeners
 * for each shop's configured space ID, and updates the listeners to enable payload
 * signature and state if not already enabled.
 */
class Webhooksignature
{
    public static function run()
    {
        //set listener service
        $listenerService = new \WhiteLabelMachineName\Sdk\Service\WebhookListenerService(
            WhiteLabelMachineNameHelper::getApiClient()
        );

        foreach (Shop::getShops(true, null, true) as $shopId) {
            $spaceId = Configuration::get(
                WhiteLabelMachineNameBasemodule::CK_SPACE_ID,
                null,
                null,
                $shopId
            );

            if (!$spaceId) {
                continue;
            }

            $query = new \WhiteLabelMachineName\Sdk\Model\EntityQuery();

            $filter = new \WhiteLabelMachineName\Sdk\Model\EntityQueryFilter();
            $filter->setType(\WhiteLabelMachineName\Sdk\Model\EntityQueryFilterType::LEAF);
            $filter->setFieldName('state');
            $filter->setOperator('EQUALS');
            $filter->setValue(\WhiteLabelMachineName\Sdk\Model\CreationEntityState::ACTIVE);

            $query->setFilter($filter);

            $listeners = $listenerService->search($spaceId, $query);

            foreach ($listeners as $listener) {
                if ($listener->getEnablePayloadSignatureAndState()) {
                    continue;
                }

                $update = new \WhiteLabelMachineName\Sdk\Model\WebhookListenerUpdate();
                $update->setId($listener->getId());
                $update->setVersion($listener->getVersion());
                $update->setEnablePayloadSignatureAndState(true);

                $listenerService->update($spaceId, $update);
            }
        }
        return true;
    }
}
