<?php

namespace Nilead\OmniBaoKim;

/**
 * Bao Kim Express Class
 */
class ExpressGateway extends ProGateway
{
    public function getName()
    {
        return 'BaoKim Express';
    }

    public function getDefaultParameters()
    {
        $settings = parent::getDefaultParameters();
        $settings['business'] = '';

        return $settings;
    }

    public function getBusiness()
    {
        return $this->getParameter('business');
    }

    public function setBusiness($value)
    {
        return $this->setParameter('business', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Nilead\OmniBaoKim\src\Message\ExpressAuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Nilead\OmniBaoKim\src\Message\ExpressCompleteAuthorizeRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->authorize($parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Nilead\OmniBaoKim\src\Message\ExpressCompletePurchaseRequest', $parameters);
    }

    public function fetchCheckout(array $parameters = array())
    {
        return $this->createRequest('\Nilead\OmniBaoKim\src\Message\ExpressFetchCheckoutRequest', $parameters);
    }
}
