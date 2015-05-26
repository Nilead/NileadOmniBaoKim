<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Express Authorize Request
 */
class ExpressAuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'returnUrl', 'cancelUrl');

        $data = $this->getBaseData();
        $data['METHOD'] = 'SetExpressCheckout';
        $data['total_amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['order_description'] = $this->getCurrency();
        $data['url_success'] = $this->getReturnUrl();
        $data['url_cancel'] = $this->getCancelUrl();

        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressAuthorizeResponse($this, $data);
    }
}
