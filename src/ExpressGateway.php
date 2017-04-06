<?php
namespace Nilead\OmniBaoKim;

use Omnipay\Common\AbstractGateway;

/**
 * Bao Kim Express Class
 */
class ExpressGateway extends AbstractGateway
{
    public function getName()
    {
        return 'BaoKim Express';
    }

    public function getDefaultParameters()
    {
        return [
            'business'        => '',
            'merchant'        => '',
            'websitePassword' => '',
            'apiUsername'     => '',
            'apiPassword'     => '',
            'apiSignature'    => '',
            'testMode'        => false,
        ];
    }

    public function getBusiness()
    {
        return $this->getParameter('business');
    }

    public function setBusiness($value)
    {
        return $this->setParameter('business', $value);
    }

    public function getMerchant()
    {
        return $this->getParameter('merchant');
    }

    public function setMerchant($value)
    {
        return $this->setParameter('merchant', $value);
    }

    public function getWebsitePassword()
    {
        return $this->getParameter('websitePassword');
    }

    public function setWebsitePassword($value)
    {
        return $this->setParameter('websitePassword', $value);
    }

    public function getApiUsername()
    {
        return $this->getParameter('apiUsername');
    }

    public function setApiUsername($value)
    {
        return $this->setParameter('apiUsername', $value);
    }

    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    public function getApiSignature()
    {
        return $this->getParameter('apiSignature');
    }

    public function setApiSignature($value)
    {
        return $this->setParameter('apiSignature', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Nilead\OmniBaoKim\Message\ExpressPurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Nilead\OmniBaoKim\Message\ExpressCompletePurchaseRequest', $parameters);
    }
}
