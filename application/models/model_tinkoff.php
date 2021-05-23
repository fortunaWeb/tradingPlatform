<?php


class Model_Tinkoff extends Model
{


    private $api_url  = 'https://securepay.tinkoff.ru/v2/';
//    private $terminalKey =  '1555126437803DEMO';
    private $terminalKey =  '1555126437803';
//    private $secretKey = 'x64wgnq8zwuc';
//    private $secretKeyWork = 'x64wgnq8zwuc';
    private $paymentId;
    private $status;
    private $error;
    private $response;
    private $paymentUrl;

    public function __construct()
    {
    }

    public function notty()
    {
        echo "OK";
    }

    public function create_payment()
    {
        if(!Helper::FilterVal('orderId')){
            return 'NO ORDER_ID';
        }
        $sell = Helper::FilterVal('sell') ? Helper::FilterVal('sell') : 0;
        $rent = Helper::FilterVal('rent') ? Helper::FilterVal('rent') : 0;
        $pay_parse = Helper::FilterVal('pay_parse') ? Helper::FilterVal('pay_parse') : 0;
        $premium = Helper::FilterVal('premium') ? Helper::FilterVal('premium') : 0;
        $premium_lenght = Helper::FilterVal('premium_lenght') ? Helper::FilterVal('premium_lenght') : 0;
        $login = substr(Helper::FilterVal('orderId'), 0, 4);
        $peopleId = current(DB::Select('people_id','re_user', "login = {$login}"))['people_id'];
        if(empty($peopleId)){
            Helper::logFile('tinkoff_payment', [['EMPTY PEOPLE SESSION'], ['POST '=>$_POST], ['SESSION' => $_SESSION]]);
            return "EMPTY PEOPLE SESSION";
        }
        DB::Insert('re_payment_tinkoff',
            '`people_id`, `order_id`, `amount`, `rent`, `sell`, `pay_parse`, `premium`, `premium_lenght`,`created`,`success`',
            $peopleId.', '.Helper::FilterVal('orderId').','.Helper::FilterVal('amount').', '
        . $rent.', '. $sell .', '.$pay_parse.', '.$premium.', '.$premium_lenght. ', NOW(), 0'
            );
        $order = DB::Select('id','re_payment_tinkoff', 'order_id='.Helper::FilterVal('orderId').' AND people_id = '.$peopleId);
        if(isset(current($order)['id'])){
            return 'OK';
        }
        return "NOT SAVE PAYMENT";
    }

    public function getState($args)
    {
        return $this->buildQuery('GetState', $args);
    }

    public function buildQuery($path, $args)
    {
        $url =$this->api_url;
        if (is_array($args)) {
            if (!array_key_exists('TerminalKey', $args)) {
                $args['TerminalKey'] = $this->terminalKey;
            }
            if (!array_key_exists('Token', $args)) {
                $args['Token'] = $this->_genToken($args);
            }
        }
        $url = $this->_combineUrl($url, $path);


        return $this->_sendRequest($url, $args);
    }

    private function _genToken($args)
    {
        $token = '';
        $args['Password'] = $this->secretKey;
        ksort($args);

        foreach ($args as $arg) {
            if (!is_array($arg)) {
                $token .= $arg;
            }
        }
        $token = hash('sha256', $token);

        return $token;
    }

    private function _combineUrl()
    {
        $args = func_get_args();
        $url = '';
        foreach ($args as $arg) {
            if (is_string($arg)) {
                if ($arg[strlen($arg) - 1] !== '/') $arg .= '/';
                $url .= $arg;
            } else {
                continue;
            }
        }

        return $url;
    }
    private function _sendRequest($api_url, $args)
    {
        $this->error = '';
        if (is_array($args)) {
            $args = json_encode($args);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        $out = curl_exec($curl);
        $this->response = $out;
        $json = json_decode($out);

        if ($json) {
            if (@$json->ErrorCode !== "0") {
                $this->error = @$json->Details;
            } else {
                $this->paymentUrl = @$json->PaymentURL;
                $this->paymentId = @$json->PaymentId;
                $this->status = @$json->Status;
            }
        }

        curl_close($curl);
        return $out;
    }

}