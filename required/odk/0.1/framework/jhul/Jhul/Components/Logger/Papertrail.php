<?php namespace Jhul\Components\Logger;

class Papertrail
{

	protected $_app_name;

	protected $_host_name;

	protected $_port;

	public function __construct( $c )
	{
		$this->_app_name = $c['app_name'];
		$this->_host_name = $c['host_name'];
		$this->_port = $c['port'];
	}

	public function log($message, $component = "web", $appName = NULL )
	{
		if( empty($appName) ) $appName = $this->_app_name;

		$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		foreach(explode("\n", $message) as $line)
		{
			$syslog_message = "<22>" . date('M d H:i:s ') . $appName . ' ' . $component . ': ' . $line;
			socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, $this->_host_name, $this->_port );
		}

		socket_close($sock);
	}

}
