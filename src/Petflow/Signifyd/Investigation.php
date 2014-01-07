<?php namespace Petflow\Signifyd;

use \Petflow\Signifyd\Client;

/**
 * Investigation (case)
 *
 * This is an interface for an Investigation, also known as a case. This
 * class provides the ability to create new cases (POST) and retrieve
 * cases (GET).
 *
 * @author Nate Krantz <nate@petflow.com>
 */
class Investigation {

	/**
	 * Client
	 * @var [type]
	 */
	protected static $client = null;

	/**
	 * Construction
	 *
	 * When creating a case resource, a key must be provided. The constructor 
	 * will instantiate the client, which is a singleton.
	 * 
	 * @param [type] $credentials [description]
	 */
	public function __construct($credentials = null) {
		if (!isset($credentials['key'])) {
			throw new \InvalidArgumentException('Must provide an API key to create a client.');
		}
		if (self::$client === null) {
			$client = new Client\Signifyd($credentials['key']);
			self::$client = $client->get();
		}
	}

	/**
	 * Create Case
	 *
	 * Using an array of data provided, post a request to the API to create a 
	 * new case.
	 * 
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function post(array $data) {
		try {
			// create the case
			$response = self::$client->post('cases', null, json_encode($data))->send();

			if (!$response->isSuccessful()) {
				return [
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'case_id' => false,
				];
			}

			// return the case id
			return [
				'success' => true,
				'case_id' => $response->json()['investigationId']
			];

		} catch (\Exception $e) {
			return [
				'success' => false,
				'case_id' => false,
				'reason'  => $e->getMessage(),
			];
		}
	}

	/**
	 * Get Case
	 *
	 * Using the case id provided, attempt to locate and retrieve the case
	 * and return it to the sender.
	 * 
	 * @param [type] [varname] [description]
	 * @return [type] [description]
	 */
	public function get($case_id) {
		try {
			// get the case
			$response = self::$client->get('cases/'.$case_id)->send();

			if (!$response->isSuccessful()) {
				return [
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'response' => false
				];
			}

			// return the case id
			return [
				'success' => true,
				'response' => $response->json()
			];

		} catch (\Exception $e) {
			return [
				'success' => false,
				'reason'  => $e->getMessage(),
				'response' => false
			];
		}
	}

	public function getByOrderID($order_id) {
		try {
			// get the case
			$response = self::$client->get("orders/$order_id/case")->send();

			if (!$response->isSuccessful()) {
				return [
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'response' => false
				];
			}

			// return the case id
			return [
				'success' => true,
				'response' => $response->json()
			];

		} catch (\Exception $e) {
			return [
				'success' => false,
				'reason'  => $e->getMessage(),
				'response' => false
			];
		}
	}

}

