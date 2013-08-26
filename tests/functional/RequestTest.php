<?php

/**
 * Sending Cases
 */
class RequestTest extends FunctionalTestCase {
		
	/**
	 * Test creating case returns id
	 */
	public function testCreateFraudCaseReturnsCaseId() {
		$investigation = new \Petflow\Signifyd\Investigation(self::credentials());

		$result = $investigation->post(self::non_fraud_case());

		$this->assertTrue($result['success']);
		$this->assertInternalType('integer', $result['case_id']);
	}

	/**
	 * Retrieve a fraud case
	 */
	public function testRetrieveFraudCaseReturnsNecessaryComponents() {
		$investigation = new \Petflow\Signifyd\Investigation(self::credentials());

		$result = $investigation->get(63205);

		$this->assertInternalType('array', $result['response']);
		$this->assertArrayHasKey('status', $result['response']);
		$this->assertArrayHasKey('orderId', $result['response']);
		$this->assertArrayHasKey('scoreCategory', $result['response']);
		$this->assertArrayHasKey('adjustedScore', $result['response']);
	}

	/**
	 * Non Fraud Case
	 */
	private static function non_fraud_case() {
		return json_decode(file_get_contents(__DIR__.'../../data/test_cases.json'), true)['non_fraudulent_1'];
	}

	/**
	 * Fraud Case
	 */
	private static function fraud_case() {
		return json_decode(file_get_contents(__DIR__.'../../data/test_cases.json'), true)['fraudulent_1'];
	}

}