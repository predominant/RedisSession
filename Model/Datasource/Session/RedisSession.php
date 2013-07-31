<?php

App::uses('CakeSessionHandlerInterface', 'Model/Datasource/Session');
App::uses('AuthComponent', 'Controller/Component');

class RedisSession extends Object implements CakeSessionHandlerInterface {

	protected $_prefix = 'PHPREDIS_SESSION';

	protected $_timeout = 600;

	protected $_store = null;

	protected $_host = 'localhost';

	protected $_port = 6379;

	protected $_password = false;

	public function __construct() {
		$this->_store = new Redis();
	}

	protected function _configure() {
		$config = Configure::read('Session');
		$this->_timeout = $config['timeout'];
		if (!empty($config['handler']['host'])) {
			$this->_host = $config['handler']['host'];
		}
		if (!empty($config['handler']['port'])) {
			$this->_port = $config['handler']['port'];
		}
		if (!empty($config['handler']['password'])) {
			$this->_password = $config['handler']['password'];
		}
		if (!empty($config['handler']['prefix'])) {
			$this->_prefix = $config['handler']['prefix'];
		}
	}

	public function open() {
		$this->_configure();
		$connected = $this->_store->connect($this->_host, $this->_port);
		if ($connected && $this->_password) {
			$this->_store->auth($this->_password);
		}
		return $connected;
	}

	public function close() {
		return $this->_store->close();
	}

	public function read($id) {
		$id = sprintf('%s:%s', $this->_prefix, $id);
		return $this->_store->get($id);
	}

	public function write($id, $data) {
		$id = sprintf('%s:%s', $this->_prefix, $id);
		return $this->_store->setex($id, $this->_timeout, $data);
	}

	public function destroy($id) {
		$id = sprintf('%s:%s', $this->_prefix, $id);
		return $this->_store->delete($id);
	}

	public function gc($expires = null) {
		return true;
	}
}
