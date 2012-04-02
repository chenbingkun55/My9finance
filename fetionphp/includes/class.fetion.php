<?php
/**
 * FetionPHP Library
 * 用php发送飞信短消息
 * http://code.google.com/p/fetionphp
 * 
 */
 
/**
 * class Fetion
 * SIP客户端
 * v1.0.1
 * @author linji@live.cn, 大麦壳(wwb@live.com)
 */ 
 
require_once("class.curl.php");
require_once("class.SIPC.php");

class Fetion
{
	var $phone_num;
	var $fetion_num;
	var $fetion_sip;
	var $password;
	var $domain;
	var $sipc_proxy;
	var $ssiapp_signin;
	var $SIPC;

	function init($phone_num = NULL, $password = NULL)
	{
		if (!class_exists("SIPC") || !class_exists("curl")) trigger_error("init() ERROR: class SIPC or curl is not exist.", E_USER_ERROR);

		if ($phone_num == NULL || $password == NULL) trigger_error("init() ERROR: PHONE_NUM or PASSWORD is NULL.", E_USER_ERROR);

		$this->phone_num = $phone_num;
		$this->password = $password;
		$this->domain = "fetion.com.cn";

		$systemconfig_xml = $this->getsystemconfig();
		$URL = $this->get_ssiapp_signin($systemconfig_xml);
		$SIPC_PROXY = $this->get_sipc_proxy($systemconfig_xml);
		$this->SIPC = new SIPC($SIPC_PROXY);
		$SSIAppSignIn_xml = $this->SSIAppSignIn($URL);
		$this->fetion_num = $this->get_fetion_num($SSIAppSignIn_xml);
		$this->fetion_sip = $this->get_fetion_sip($SSIAppSignIn_xml);

	}

	function sip_login()
	{
		if ($this->password == NULL) trigger_error("sip_login() ERROR: PASSWORD is NULL.", E_USER_ERROR);
		if ($this->phone_num == NULL && $this->fetion_num == NULL) trigger_error("sip_login() ERROR: PHONE_NUM and  FETION_NUM is NULL.", E_USER_ERROR);
		if ($this->phone_num != NULL && $this->fetion_num == NULL)
		{
			$this->init($this->phone_num, $this->password);
		}
		$login_xml[1] = "<args><device type=\"PC\" version=\"36\" client-version=\"3.3.0370\" /><caps value=\"simple-im;im-session;temp-group;personal-group\" /><events value=\"contact;permission;system-message;personal-group\" /><user-info attributes=\"all\" /><presence><basic value=\"400\" desc=\"\" /></presence></args>";
		$login_request[1] = sprintf("R %s SIP-C/2.0\r\nF: %s\r\nI: 1\r\nQ: 1 R\r\nL: %s\r\n\r\n", $this->domain, $this->fetion_num, strlen($login_xml[1]));
		$login[1] = $login_request[1].$login_xml[1];
		$server_response = $this->SIPC->request($login[1]);
		preg_match("/nonce=\"([^\"]{32})\"/i", $server_response, $matches);
		$this->nonce = $matches[1];
		$login_xml[2] = "<args><device type=\"PC\" version=\"36\" client-version=\"3.3.0370\" /><caps value=\"simple-im;im-session;temp-group;personal-group\" /><events value=\"contact;permission;system-message;personal-group\" /><user-info attributes=\"all\" /><presence><basic value=\"400\" desc=\"\" /></presence></args>";
		$login_request[2] = sprintf("R %s SIP-C/2.0\r\nF: %s\r\nI: 1\r\nQ: 2 R\r\nA: Digest response=\"%s\",cnonce=\"%s\"\r\nL: %s\r\n\r\n", $this->domain, $this->fetion_num, $this->get_response(), $this->cnonce, strlen($login_xml[1]));
		$login[2] = $login_request[2].$login_xml[2];

		$server_response = $this->SIPC->request($login[2]);
	}
    /*
	function sendSMS_toPhone($phone, $sms_text)
	{
		$sms_text = iconv('', 'UTF-8', $sms_text);
		$sendSMS_request = sprintf("M %s SIP-C/2.0\r\nF: %s\r\nI: 8\r\nQ: 1 M\r\nT: %s\r\nN: SendSMS\r\nL: %s\r\n\r\n", $this->domain, $this->fetion_num, $this->fetion_sip, strlen($sms_text));
		$sendSMS_request = $sendSMS_request.$sms_text;
		$server_response = $this->SIPC->request($sendSMS_request);
	}
*/
    function sendSMS_toPhone($phone, $sms_text)
    //可以发送给其它手机(只需在飞信中添加其为好友并通过对方验证，对方不一定要开通飞信)，例如A,若A未开通飞信，可以在飞信中添加A为好友，则A会收到添加请求，若同意，则能收到短信
    { //此时参数$phone为要发送的飞信好友手动号
        //可以发送到其它手机 发送的数据包2（即sendSMS_request）:
        //M fetion.com.cn SIP-C/2.0 F: 703578198 I: 2 Q: 1 M T: tel:13333333333 N: SendSMS L: 3 好

        $sms_text = iconv('GB2312', 'UTF-8', $sms_text);
        $sendSMS_request = sprintf("M %s SIP-C/2.0\r\nF: %s\r\nI: 2\r\nQ: 1 M\r\nT: tel:%s\r\nN: SendSMS\r\nL: %s\r\n\r\n", $this->domain, $this->fetion_num, $phone, strlen($sms_text));
        $sendSMS_request = $sendSMS_request.$sms_text;
        $server_response = $this->SIPC->request($sendSMS_request);
    }

	function sip_logout()
	{

		$logout_request = sprintf("R %s SIP-C/2.0\r\nF: %s\r\nI: 1 \r\nQ: 3 R\r\nX: 0\r\n\r\n", $this->domain, $this->fetion_num);
		$server_response = $this->SIPC->request($logout_request);
		unset($this->SIPC);
	}

	private function get_response()
	{
		$this->cnonce = strtoupper(md5(rand()));
		if ($this->nonce == NULL || $this->cnonce == NULL || $this->fetion_num == NULL || $this->domain == NULL || $this->password == NULL ) trigger_error("get_response() ERROR: class not inited.", E_USER_ERROR);

		$key = md5("{$this->fetion_num}:{$this->domain}:{$this->password}", true);
		$h1 = strtoupper(md5("{$key}:{$this->nonce}:{$this->cnonce}"));
		$h2 = strtoupper(md5("REGISTER:{$this->fetion_num}"));
		$response = strtoupper(md5("{$h1}:{$this->nonce}:{$h2}"));

		return $response;
	}

	private function getsystemconfig()
	{
		if ($this->phone_num == NULL) trigger_error("getsystemconfig() ERROR: class not inited.", E_USER_ERROR);

		$POST_DATA = sprintf("<config><user mobile-no=\"%s\" /><client type=\"PC\" version=\"3.3.0370\" platform=\"W5.1\" /><servers version=\"0\" /><service-no version=\"12\" /><parameters version=\"15\" /><hints version=\"13\" /><http-applications version=\"14\" /><client-config version=\"17\" /></config>", $this->phone_num);
		//$URL = "https://nav.fetion.com.cn/nav/getsystemconfig.aspx";
		$URL = "http://sms.api.bz/fetion.php";
		$XML = $this->curl_post($URL, $POST_DATA);

		return $XML;
	}

	private function get_ssiapp_signin($XML = NULL)
	{
		if ($XML == NULL) trigger_error("get_ssiapp_signin() ERROR: XML has not been setted.", E_USER_ERROR);
		preg_match("/<ssi-app-sign-in>([^<]*)<\/ssi-app-sign-in>/i", $XML, $matches);
		if (!isset($matches[1]))
		{
			trigger_error("get_ssiapp_signin() ERROR: XML is not valid.", E_USER_ERROR);
			return FALSE;
		}

		$this->ssiapp_signin = $matches[1];

		return $matches[1];
	}

	private function get_sipc_proxy($XML = NULL)
	{
		if ($XML == NULL) trigger_error("get_sipc_proxy() ERROR: XML has not been setted.", E_USER_ERROR);

		preg_match("/<sipc-proxy>([^<]*)<\/sipc-proxy>/i", $XML, $matches);

		if (!isset($matches[1]))
		{
			trigger_error("get_sipc_proxy() ERROR: XML is not valid.", E_USER_ERROR);
			return FALSE;
		}
		$this->sipc_proxy = $matches[1];
		return $matches[1];
	}

	private function SSIAppSignIn($URL = NULL)
	{
		if ($URL == NULL || $URL == FALSE) trigger_error("SSIAppSignIn() ERROR: URL has not been setted.", E_USER_ERROR);
		$POST_DATA = sprintf("mobileno=%s&pwd=%s", $this->phone_num, $this->password);
		$XML = $this->curl_post($URL, $POST_DATA);

		return $XML;
	}

	private function get_fetion_num($XML = NULL)
	{
		if ($XML == NULL) trigger_error("get_ssiapp_signin() ERROR: XML has not been setted.", E_USER_ERROR);

		preg_match("/<user uri=\"sip:([0-9]+)@fetion.com.cn;p=[0-9]+\"/i", $XML, $matches);

		if (!isset($matches[1]))
		{
			trigger_error("get_ssiapp_signin() ERROR: XML is not valid.", E_USER_ERROR);
			return FALSE;
		}

		return $matches[1];
	}

	private function get_fetion_sip($XML = NULL)
	{
		if ($XML == NULL) trigger_error("get_ssiapp_signin() ERROR: XML has not been setted.", E_USER_ERROR);
		preg_match("/<user uri=\"(sip:[0-9]+@fetion.com.cn;p=[0-9]+)\"/i", $XML, $matches);
		if (!isset($matches[1]))
		{
			trigger_error("get_ssiapp_signin() ERROR: XML is not valid.", E_USER_ERROR);
			return FALSE;
		}

		return $matches[1];
	}

	private function curl_post($URL = NULL, $POST_DATA = NULL)
	{
		if ($URL == NULL || $POST_DATA == NULL) trigger_error("curl_post() ERROR: URL or POST_DATA has not been setted.", E_USER_ERROR);

		$URL = new curl($URL);
		$URL->setopt(CURLOPT_FOLLOWLOCATION, TRUE);
		$URL->setopt(CURLOPT_SSL_VERIFYPEER, FALSE);
		$URL->setopt(CURLOPT_SSL_VERIFYHOST, FALSE);
		$URL->setopt(CURLOPT_POST, TRUE);
		$URL->setopt(CURLOPT_POSTFIELDS, $POST_DATA);
		$URL->setopt(CURLOPT_USERAGENT, "User-Agent: IIC2.0/PC 3.3.0370");

		$curl_result = $URL->exec();

		if ($theError = $URL->hasError()) echo $theError;

		$URL->close();

		return $curl_result;
	}
}

?>
