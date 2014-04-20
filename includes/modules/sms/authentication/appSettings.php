<?php 
    $appid = "280118400000032264";
    $appsecret = "ba77886c87431603230c7fad6b0a7ead";
    $redirectUri = "http://101.227.251.180:10001/open189/authentication/redirect.php";
    $authorizeAPI = "https://oauth.api.189.cn/emp/oauth2/v3/authorize";
    $tokenAPI = "https://oauth.api.189.cn/emp/oauth2/v3/access_token";
/**
 * curl�ຯ��
 */
//post��ʽ�ύ��ȡ���
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

//get��ʽ�ύ��ȡ���
function curl_get($url='', $options=array()){
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
?>