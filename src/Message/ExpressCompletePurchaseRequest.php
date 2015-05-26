<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Express Complete Purchase Request
 */
class ExpressCompletePurchaseRequest extends ExpressCompleteAuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();

        return $data;
    }
}
