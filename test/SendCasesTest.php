<?php

/**
 * Sending Cases
 */
class SendCasesTest extends FunctionalTestCase {
		
	/**
	 * Send a Non-Fraudulent Test Case
	 */
	public function sendNonFraudulentCaseTest() {
		$file = self::non_fraud_case();
	}

	/**
	 * Send a Fraudulent Test Case
	 */
	public function sendFraudulentTestCase() {}

	/**
	 * Non Fraud Case
	 */
	private static function non_fraud_case() {
		$file = file_get_contents('./test_cases.json');

		print $file;
	}

	/**
	 * Fraud Case
	 */
	private static function fraud_case() {}

}