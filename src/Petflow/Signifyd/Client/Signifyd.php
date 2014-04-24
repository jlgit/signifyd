<?php namespace Petflow\Signifyd\Client;

use Guzzle\Http\Client;

/**
 * A signifyd wrapper for their restful http api.
 *
 * @todo next major version: fix the dependencies here
 */
class Signifyd {

	/**
	 * Guzzle Client
	 * 
	 * @var \Guzzle\Http\Client
	 */
	protected $client;

	/**
	 * Construct a new Signifyd instance, using the passed
	 */
	public function __construct($key) {
		$this->set(
			new Client('https://api.signifyd.com/{version}', array(
				'version'         => 'v2',
				'request.options' => [
					'headers' => [
						'Accept' 	   => 'application/json',
						'Content-Type' => 'application/json'
					],
					'auth'    => [$key, '', 'Basic']
				]
			))
		);
	}

	/**
	 * Get the current http client.
	 * 
	 * @return \Guzzle\Http\Client
	 */
	public function get() {
		return $this->client;
	}

	/**
	 * Set the current Http client.
	 * 
	 * @param \Guzzle\Http\Client $client
	 */
	public function set(Client $client) {
		$this->client = $client;
	}
}
