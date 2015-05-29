<?php

namespace Nilead\OmniBaoKim\Message;

use Guzzle\Http\Message\RequestInterface;

/**
 * Bao Kim Express Complete Purchase Request
 */
class ExpressCompletePurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'http://kiemthu.baokim.vn/payment/order/queryTransaction';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/queryTransaction';

    public function getData()
    {
        $data['merchant_id'] = $this->getMerchant();
        $data['order_id'] = md5($this->getTransactionId());
        $data['transaction_id'] = $this->getTransactionReference();

        return $data;
    }

    public function sendData($data)
    {
        $signature = $this->makeBaoKimAPISignature(RequestInterface::GET, $this->baokim_api_transaction_info, $data, $this->getApiSignature());

        $url = $this->generateUrlBaoKim($signature, $data);

//        $httpResponse = $this->httpClient->get($url)->send();

//        return $this->createResponse($httpResponse->getBody());

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLINFO_HEADER_OUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST | CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $this->getApiUsername() . ':' . $this->getApiPassword());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        if(empty($result)){
            $result = array(
                'status'=>$status,
                'error'=>$error
            );
        }

        return $this->createResponse($result);
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressPurchaseResponse($this, $data);
    }

    protected function generateUrlBaoKim($signature, $data)
    {
        $data = $this->generateChecksum($data);
        $data['signature'] = $signature;

        $url = $this->getEndpoint() . '?' . http_build_query($data, '', '&');

        return $url;
    }

    public function generateChecksum($data)
    {
        ksort($data);

        $data['checksum'] = hash_hmac('SHA1', implode('', $data), $this->getWebsitePassword());

        return $data;
    }
}
