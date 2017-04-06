<?php
namespace Nilead\OmniBaoKim\Message;

/**
 * Bao Kim Pro Purchase Request
 */
class ProPurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount');
        $date = new \DateTime('now');
        $data = $this->getBaseData();
        $data['total_amount'] = $this->getAmount();
        $data['order_id'] = md5($date->getTimestamp());
        $data['transaction_mode_id'] = 1; // 1: trực tiếp / 2: an toàn, default: 1
        $data['url_success'] = $this->getReturnUrl();
        $data['url_cancel'] = $this->getCancelUrl();
        $data['currency'] = $this->getCurrency();

        return $data;
    }

    public function sendData($data)
    {
        $data = http_build_query($this->generateChecksum($data), '', '&');

        return $this->createResponse($data);
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressPurchaseResponse($this, $data);
    }
}
