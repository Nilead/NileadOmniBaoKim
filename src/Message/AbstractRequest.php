<?php
/**
 * Bao Kim Abstract Request
 */

namespace Nilead\OmniBaoKim\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = '11.0';

    protected $liveEndpoint = 'https://www.baokim.vn/payment/order/version11';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';

    public function getBusiness()
    {
        return $this->getParameter('business');
    }

    public function setBusiness($value)
    {
        return $this->setParameter('business', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getSignature()
    {
        return $this->getParameter('signature');
    }

    public function setSignature($value)
    {
        return $this->setParameter('signature', $value);
    }

    public function getNoShipping()
    {
        return $this->getParameter('noShipping');
    }

    public function setNoShipping($value)
    {
        return $this->setParameter('noShipping', $value);
    }

    public function getAllowNote()
    {
        return $this->getParameter('allowNote');
    }

    public function setAllowNote($value)
    {
        return $this->setParameter('allowNote', $value);
    }

    public function getAddressOverride()
    {
        return $this->getParameter('addressOverride');
    }

    public function setAddressOverride($value)
    {
        return $this->setParameter('addressOverride', $value);
    }

    public function getMaxAmount()
    {
        return $this->getParameter('maxAmount');
    }

    public function setMaxAmount($value)
    {
        return $this->setParameter('maxAmount', $value);
    }

    public function getTaxAmount()
    {
        return $this->getParameter('taxAmount');
    }

    public function setTaxAmount($value)
    {
        return $this->setParameter('taxAmount', $value);
    }

    public function getShippingAmount()
    {
        return $this->getParameter('shippingAmount');
    }

    public function setShippingAmount($value)
    {
        return $this->setParameter('shippingAmount', $value);
    }

    public function getHandlingAmount()
    {
        return $this->getParameter('handlingAmount');
    }

    public function setHandlingAmount($value)
    {
        return $this->setParameter('handlingAmount', $value);
    }

    public function getShippingDiscount()
    {
        return $this->getParameter('shippingDiscount');
    }

    public function setShippingDiscount($value)
    {
        return $this->setParameter('shippingDiscount', $value);
    }

    protected function getBaseData()
    {
        $data = [];
        $data['business'] = $this->getBusiness();

        return $data;
    }

    public function sendData($data)
    {
        $url = $this->getEndpoint() . '?' . http_build_query($this->generateDataWithChecksum($data), '', '&');
        $httpResponse = $this->httpClient->get($url)->send();

        return $this->createResponse($httpResponse->getBody());
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }

    protected function generateDataWithChecksum($data)
    {
        ksort($data);
        $data['checksum'] = hash_hmac('SHA1', implode('', $data), $this->getPassword());

        return $data;
    }
}
