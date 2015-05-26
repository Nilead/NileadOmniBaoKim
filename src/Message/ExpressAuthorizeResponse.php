<?php

namespace Nilead\OmniBaoKim\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Bao Kim Express Authorize Response
 */
class ExpressAuthorizeResponse extends Response implements RedirectResponseInterface
{
    protected $liveCheckoutEndpoint = 'https://www.baokim.vn/payment/order/version11';
    protected $testCheckoutEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        $query = $this->getRequest()->generateDataWithChecksum($this->getRequest()->getData());

        return $this->getCheckoutEndpoint() . '?' . http_build_query($query, '', '&');
    }

    public function getTransactionReference()
    {
        return isset($this->data['TOKEN']) ? $this->data['TOKEN'] : null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }

    protected function getCheckoutEndpoint()
    {
        return $this->getRequest()->getTestMode() ? $this->testCheckoutEndpoint : $this->liveCheckoutEndpoint;
    }
}
