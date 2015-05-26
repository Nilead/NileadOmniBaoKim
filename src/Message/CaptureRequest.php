<?php

namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Capture Request
 */
class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $data = $this->getBaseData();
        $data['METHOD'] = 'DoCapture';
        $data['total_amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();

        return $data;
    }
}
