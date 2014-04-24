<?php namespace Petflow\Signifyd;

use Petflow\Signifyd\Client\Signifyd as SignifydClient;

use \InvalidArgumentException,
	\Exception;

/**
 * An investigation class, wrapping the Signifyd REST API.
 *
 * @todo next major version: create entities for cases 1:1 to signifyd api resources
 * @todo next major version: depend on an http interface
 *
 * @author Nate Krantz <nate@petflow.com>
 */
class Investigation {

	/**
	 * The Signifyd client for HTTP interaction.
	 * 
	 * @var \Guzzle\Http\Client
	 */
	protected static $client = null;

	/**
	 * Construct a new investigation, passing in an array of credentials
	 * to be used for constructing the http client.
	 *
	 * @todo next version, depend on an http client interface rather than credentials.
	 * 
	 * @param array $credentials
	 */
	public function __construct(array $credentials = null) {
		// we need an api key
		if (!isset($credentials['key'])) {
			throw new InvalidArgumentException('Must pass an API key to Investigation for the client HTTP access.');
		}

		if (self::$client === null) {
			$this->setClient(
				new SignifydClient($credentials['key'])
			);
		}
	}

	/**
	 * Post a new case to the signifyd api via http.
	 *
	 * Using an array of data provided, post a request to the API to create a 
	 * new signifyd fraud case.
	 * 
	 * @param  array  $data
	 * 
	 * @return array     
	 */
	public function post(array $data) {
		try {
			$response = self::$client->post('cases', null, json_encode($data))->send();

			if (!$response->isSuccessful()) {
				return array(
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'case_id' => false,
				);
			}

			return array(
				'success' => true,
				'case_id' => $response->json()['investigationId']
			);

		} catch (Exception $e) {
			return array(
				'success' => false,
				'case_id' => false,
				'reason'  => $e->getMessage(),
			);
		}
	}

	/**
	 * Get a case from the signifyd api via http.
	 *
	 * This function will get a case by its unique case id, using the
	 * GET /cases/:case_id endpoint.
	 * 
	 * @param integer $case_id
	 * 
	 * @return array
	 */
	public function get($case_id) {
		try {
			$response = self::$client->get('cases/'.$case_id)->send();

			if (!$response->isSuccessful()) {
				return array(
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'response' => false
				);
			}

			return array(
				'success' => true,
				'response' => $response->json()
			);

		} catch (Exception $e) {
			return array(
				'success' => false,
				'reason'  => $e->getMessage(),
				'response' => false
			);
		}
	}

	/**
	 * Get a case by an order id from the signifyd api via http.
	 *
	 * This function will retrieve a case by its corresponding order
	 * id, using the GET /orders/:order_id/case endpoint.
	 * 
	 * @param  integer $order_id
	 * 
	 * @return array
	 */
	public function getByOrderID($order_id) {
		try {
			$response = self::$client->get("orders/$order_id/case")->send();

			if (!$response->isSuccessful()) {
				return array(
					'success' => false,
					'reason'  => $response->getStatusCode(),
					'response' => false
				);
			}

			return array(
				'success' => true,
				'response' => $response->json()
			);

		} catch (Exception $e) {
			return array(
				'success' => false,
				'reason'  => $e->getMessage(),
				'response' => false
			);
		}
	}

	/**
	 * Set a new signifyd client.
	 * 
	 * @param \Petflow\Signifyd\Client\Signifyd $signifyd
	 */
	public function setClient(SignifydClient $signifyd) {
		static::$client = $signifyd->get();
	}
}