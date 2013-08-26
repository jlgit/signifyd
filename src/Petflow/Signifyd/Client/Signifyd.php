<?php namespace Petflow\Signifyd\Client;

use Guzzle\Http\Client;

class Signifyd {

	/**
	 * Guzzle Client
	 * @var [type]
	 */
	protected $client;

	/**
	 * Create Client
	 */
	public function __construct($key) {
		$this->client = new Client('https://api.signifyd.com/{version}', [
			'version'         => 'v1',
			'request.options' => [
				'headers' => [
					'Accept' 	   => 'application/json',
					'Content-Type' => 'application/json'
				],
				'auth'    => [$key, '', 'Basic']
			]
		]);
	}

	/**
	 * Get the Client
	 * 
	 * @return [type] [description]
	 */
	public function get() {
		return $this->client;
	}
}