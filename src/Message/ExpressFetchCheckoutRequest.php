<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Express Fetch Checkout Details Request
 */
class ExpressFetchCheckoutRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate();

        $data = $this->getBaseData();
        $data['METHOD'] = 'GetExpressCheckoutDetails';

        return $data;
    }
}
