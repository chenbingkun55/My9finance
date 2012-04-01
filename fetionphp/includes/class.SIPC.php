<?php
/**
 * FetionPHP Library
 * 用php发送飞信短消息
 * http://code.google.com/p/fetionphp
 * 
 */
 
/**
 * class SIPC
 * SIP客户端
 * v1.0
 * @author linji@live.cn
 */ 
 
class SIPC
{
	var $_ip;
	var $_port;
	var $_request;
	var $_response;
	var $_socket;

	function SIPC($SIPC_addr = NULL)
	{
		if (!function_exists("socket_create")) trigger_error("PHP was not built with --with-socket, rebuild PHP to use the socket class.", E_USER_ERROR);

		if ($SIPC_addr == NULL) trigger_error("SIPC() ERROR: SIPC_addr is not set.", E_USER_ERROR);
		$addr = explode(":", $SIPC_addr);
		$this->_ip = $addr[0];
		$this->_port = $addr[1];
		
		$this->socket_init();

	}

	function request($sip_request = NULL)
	{
		if ($sip_request == NULL) trigger_error("socket_write() ERROR: SIPC_REQUEST is not set.", E_USER_ERROR);

		$this->socket_write($sip_request);
		$sip_response = $this->socket_read($this->_socket);
		return $sip_response;
	}

	private function socket_init()
	{
		if ($this->_ip == NULL || $this->_port == NULL) trigger_error("socket_init() ERROR: IP or PORT is not set.", E_USER_ERROR);
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_connect($this->_socket, $this->_ip, $this->_port);
		return $this->_socket;
	}

	private function socket_write($data = NULL)
	{
		if ($data == NULL) trigger_error("socket_write() ERROR: DATA is not set.", E_USER_ERROR);
		socket_write($this->_socket, $data, strlen($data));
	}

	private function socket_read()
	{
		do
		{
			@$socket_content = $socket_content . socket_read($this->_socket, 4, PHP_BINARY_READ);
		} while ((bool) strpos($socket_content, "\r\n\r\n") === FALSE);

		preg_match("/L: ([0-9]+)/i", $socket_content, $matches);
		if (is_array($matches) && isset($matches[1]))
		{
			$length = $matches[1];
			$socket_content = $socket_content . socket_read($this->_socket, $length, PHP_BINARY_READ);
		}
		return $socket_content;
	}
}
?>