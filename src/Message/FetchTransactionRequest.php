<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Fetch Transaction Request
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        $data = $this->getBaseData();
        $data['METHOD'] = 'GetTransactionDetails';
        $data['transaction_id'] = $this->getTransactionReference();

        return $data;
    }
}
