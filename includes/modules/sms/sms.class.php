<?php

class sms
{
    const ACURL = "https://oauth.api.189.cn/emp/oauth2/v3/access_token";
    const SCURL = "http://api.189.cn/v2/dm/randcode/token";
    const SMSURL = "http://api.189.cn/v2/dm/randcode/sendSms";
    function sms($appid,$appSecret)
    {
        $this->appid = $appid;
        $this->appSecret = $appSecret;
        $acdata="grant_type=client_credentials&app_id=$appid&app_secret=$appSecret";
        $option=Array(
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE
        );
        $ret = $this->curl_post($this::ACURL,$acdata,$option);
        $content = json_decode($ret,true);
        if($content['res_code']==0)
            $this->access_token=$content['access_token'];
        $param=Array(
			"access_token" => "access_token=" . $this->access_token,
			"app_id"=> "app_id=" . $appid,
			"timestamp"=> "timestamp=" . date("Y-m-d H:i:s")
        );
		$plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $appSecret, $raw_output=True)));
        ksort($param);
        $url = implode("&",$param);
        $url = $this::SCURL . "?" . $url;
		$ret = $this->curl_get($url);
        $content=json_decode($ret,true);

        if($content['res_code']==0)
            $this->sms_token=$content['token'];
        else exit;
    }
    //TODO:等短信接口
    public function send_sms($phonenumber,$verifycode)
    {
        $url = "http://api.189.cn/v2/dm/randcode/sendSms";
        
        $param['app_id']= "app_id=".$this->appid;
        $param['access_token'] = "access_token=".$this->access_token;
        $param['timestamp'] = "timestamp=".date("Y-m-d H:i:s");
        $param['token'] = "token=".$this->sms_token;
        $param['phone'] = "phone=".$phonenumber;
        $param['randcode'] = "randcode=".$verifycode;
        $param['exp_time'] = "exp_time=";
        ksort($param);
        $plaintext = implode("&",$param);
        $param['sign'] = "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $this->appSecret, $raw_output=True)));
        ksort($param);
        $str = implode("&",$param);
        $result = $this->curl_post($url,$str);
        $content = json_decode($result,true);

        return true;
    }
    
    
	function curl_post($url='', $postdata='', $options=array()){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		if (!empty($options)){
			curl_setopt_array($ch, $options);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
    
    private function curl_get($url='', $options=array()){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if (!empty($options)){
            curl_setopt_array($ch, $options);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    

    
    private $appid;
    private $appSecret;
    
    private $access_token;
    private $sms_token;
} 

?>