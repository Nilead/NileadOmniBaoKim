<?php
namespace Nilead\OmniBaoKim\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Bao Kim Pro Purchase Response
 */
class ProPurchaseResponse extends Response implements RedirectResponseInterface
{
    protected $liveEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';

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
        return $this->getCheckoutEndpoint() . '?' . http_build_query($this->data, '', '&');
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
        return $this->getRequest()->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}