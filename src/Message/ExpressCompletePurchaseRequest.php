<?php

namespace Nilead\OmniBaoKim\Message;


/**
 * Bao Kim Express Complete Purchase Request
 */
class ExpressCompletePurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'http://kiemthu.baokim.vn/payment/order/queryTransaction';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/queryTransaction';

    public function getData()
    {
        $this->validate('amount');

        $data = $this->getBaseData();
        $data['total_amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();

        return $data;
    }

    public function sendData($data)
    {
        $signature = $this->makeBaoKimAPISignature('get', $this->baokim_api_transaction_info, $data, $this->getApiSignature());

        $url = $this->generateUrlBaoKim($signature, $data);
        $httpResponse = $this->httpClient->get($url);

        return $this->createResponse($httpResponse->getBody());
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressPurchaseResponse($this, $data);
    }

    protected function generateUrlBaoKim($signature, $data)
    {

        $url = $this->getEndpoint() . '?' . 'signature=' . $signature . '&' . http_build_query($data, '', '&');

        return $url;
    }
}
