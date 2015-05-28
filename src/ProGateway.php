<?php
namespace Nilead\OmniBaoKim;

/**
 * Bao Kim Pro Class
 */
class ProGateway extends ExpressGateway
{
    public function getName()
    {
        return 'BaoKim Pro';
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Nilead\OmniBaoKim\Message\ProPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Nilead\OmniBaoKim\Message\ProCompletePurchaseRequest', $parameters);
    }

}