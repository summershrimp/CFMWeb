<?php

class sms
{
    const ACURL = "https://oauth.api.189.cn/emp/oauth2/v3/access_token";
    const SCURL = "http://api.189.cn/v2/dm/randcode/token";
    const SMSURL = "http://api.189.cn/v2/dm/randcode/sendSms";
    function sms()
    {
        $option=Array(
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE
        );
        $ret = $this->curl_post($this::ACURL,$this::ACDATA,$option);
        echo "get access_token<br>";
        echo $ret;
        echo "<br>";
        $content = json_decode($ret,true);
        if($content['res_code']==0)
            $this->access_token=$content['access_token'];
        $get="access_token=$this->access_token&app_id=".$this::APPID."&timestamp=".date("Y-m-d h:i:s");
        $sign=base64_encode(hash_hmac("sha1", $get, $this::APPSEC));
        $get=$get."&sign=$sign";
        $ret=$this->curl_get($get);
        echo "get token<br>";
        echo $ret;
        echo "<br>";
        $content=json_decode($ret,true);
        if($content['res_code']==2)
            $this->sms_token=$content['token'];
    }
    //TODO:等短信接口
    public function send_sms($phonenumber,$verifycode)
    {
        $get=
            "accesstoken=$this->access_token&
             app_id=".$this::APPID."&
             timestamp=".date("Y-m-d h:i:s")."&
             token=$this->sms_token&
             phone=$phonenumber&
             randcode=$verifycode&
            ";
        $sign=base64_encode(hash_hmac("sha1", $get, $this::APPSEC));
        $get=$get."&sign=$sign";
        $ret=$this->curl_get($get);
        echo "get send confirm<br>";
        echo $ret;
        echo "<br>";
        $content=json_decode($ret,true);
        
        return true;
    }
    
    
    private function curl_post($url='', $postdata='', $options=array()){
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
    
    const APPID="391791200000035308";
    const APPSEC="bea5b8c7025d6357d2d6c151ec017c3e";
    
    const ACDATA="
        grant_type=client_credentials&
        app_id=391791200000035308&
        app_secret=bea5b8c7025d6357d2d6c151ec017c3e";
    private $access_token;
    private $sms_token;
} 

?>
