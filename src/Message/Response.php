<?php

namespace Nilead\OmniBaoKim\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Bao Kim Response
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        parse_str($data, $this->data);
    }

    public function isSuccessful()
    {
        return false;
    }

    public function getTransactionReference()
    {
        foreach (['REFUNDTRANSACTIONID', 'TRANSACTIONID', 'PAYMENTINFO_0_TRANSACTIONID'] as $key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }
        }
    }

    public function getMessage()
    {
        return isset($this->data['L_LONGMESSAGE0']) ? $this->data['L_LONGMESSAGE0'] : null;
    }
}
