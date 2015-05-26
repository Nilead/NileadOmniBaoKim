<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Express Complete Authorize Request
 */
class ExpressCompleteAuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount');

        $data = $this->getBaseData();
        $data['METHOD'] = 'DoExpressCheckoutPayment';
        $data['total_amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['order_description'] = $this->getCurrency();
        $data['url_success'] = $this->getReturnUrl();
        $data['url_cancel'] = $this->getCancelUrl();

        return $data;
    }
}
