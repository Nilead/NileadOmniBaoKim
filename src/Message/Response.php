<?php
namespace Nilead\OmniBaoKim\Message;

use League\Omnipay\Common\Message\AbstractResponse;
use League\Omnipay\Common\Message\RequestInterface;

/**
 * Bao Kim Response
 */
class Response extends AbstractResponse
{
    protected $transactionStatus = [
        '1'  => 'giao dịch chưa xác minh OTP',
        '2'  => 'giao dịch đã xác minh OTP',
        '4'  => 'giao dịch hoàn thành',
        '5'  => 'giao dịch bị hủy',
        '6'  => 'giao dịch bị từ chối nhận tiền',
        '7'  => 'giao dịch hết hạn',
        '8'  => 'giao dịch thất bại',
        '12' => 'giao dịch bị đóng băng',
        '13' => 'giao dịch bị tạm giữ (thanh toán an toàn)',
        'X'  => 'các trạng thái giao dịch khác'
    ];

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        parse_str($data, $this->data);
    }

    public function isCompleted()
    {
        return (empty($this->data['error']) && !empty($this->data['transaction_status']) && $this->getCode() < 400) && (($this->data['transaction_status'] == 4) || ($this->data['transaction_status'] == 13));
    }

    public function getTransactionReference()
    {
        return isset($this->data['transaction_id']) ? $this->data['transaction_id'] : null;
    }

    public function getMessage()
    {
        return null;
    }

    public function transactionStatusMessage($key)
    {
        if (array_key_exists($key, $this->transactionStatus)) {
            return $this->transactionStatus[$key];
        }

        return null;
    }
}
