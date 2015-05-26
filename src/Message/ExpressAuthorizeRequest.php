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
        $data['url_success'] = $this->getReturnUrl();
        $data['url_cancel'] = $this->getCancelUrl();
        $data['order_id'] = $this->getTransactionId();
        $data['currency'] = $this->getCurrency();
        return $data;
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressAuthorizeResponse($this, $data);
    }
}
