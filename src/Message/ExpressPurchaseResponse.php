<?php
namespace Nilead\OmniBaoKim\Message;

use League\Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Bao Kim Express Authorize Response
 */
class ExpressPurchaseResponse extends Response implements RedirectResponseInterface
{
    protected $liveEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';

    public function isCompleted()
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
