<?php
/**
 * Bao Kim Abstract Request
 */
namespace Nilead\OmniBaoKim\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = '11.0';

    protected $liveEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';
    protected $testEndpoint = 'http://kiemthu.baokim.vn/payment/order/version11';

    protected $baokim_api_seller_info = '/payment/rest/payment_pro_api/get_seller_info';
    protected $baokim_api_transaction_info = '/payment/order/queryTransaction';
    protected $baokim_api_payment_pro = '/payment/rest/payment_pro_api/pay_by_card';

    public function getBusiness()
    {
        return $this->getParameter('business');
    }

    public function setBusiness($value)
    {
        return $this->setParameter('business', $value);
    }

    public function getMerchant()
    {
        return $this->getParameter('merchant');
    }

    public function setMerchant($value)
    {
        return $this->setParameter('merchant', $value);
    }

    public function getWebsitePassword()
    {
        return $this->getParameter('websitePassword');
    }

    public function setWebsitePassword($value)
    {
        return $this->setParameter('websitePassword', $value);
    }

    public function getApiUsername()
    {
        return $this->getParameter('apiUsername');
    }

    public function setApiUsername($value)
    {
        return $this->setParameter('apiUsername', $value);
    }

    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    public function getApiSignature()
    {
        return $this->getParameter('apiSignature');
    }

    public function setApiSignature($value)
    {
        return $this->setParameter('apiSignature', $value);
    }

    public function generateChecksum($data)
    {
        ksort($data);

        $data['checksum'] = hash_hmac('SHA1', implode('', $data), $this->getWebsitePassword());

        return $data;
    }

    public function sendData($data)
    {
        $url = $this->getEndpoint() . '?' . http_build_query($data, '', '&');
        $httpResponse = $this->httpClient->get($url)->send();

        return $this->createResponse($httpResponse->getBody());
    }

    /**
     * @param       $method
     * @param       $url
     * @param array $getArgs
     * @param       $priKeyFile
     *
     * @return string
     */
    public function makeBaoKimAPISignature($method, $url, $getArgs = [], $priKeyFile)
    {
        if (strpos($url, '?') !== false) {
            list($url, $get) = explode('?', $url);
            parse_str($get, $get);
            $getArgs = array_merge($get, $getArgs);
        }

        ksort($getArgs);
        $method = strtoupper($method);

        $data = $method . '&' . urlencode($url) . '&' . urlencode(http_build_query($getArgs));

        $priKey = openssl_get_privatekey($priKeyFile);
        assert('$priKey !== false');

        $x = openssl_sign($data, $signature, $priKey, OPENSSL_ALGO_SHA1);
        assert('$x !== false');

        return urlencode(base64_encode($signature));
    }

    protected function createResponse($data)
    {
        return $this->response = new ExpressCompletePurchaseResponse($this, $data);
    }

    protected function getBaseData()
    {
        $data = [];
        $data['business'] = $this->getBusiness();
        $data['merchant_id'] = $this->getMerchant();

        return $data;
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
