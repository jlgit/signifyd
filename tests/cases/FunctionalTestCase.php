<?php

/**
 * Functional Test Case
 *
 * A test case that will hit external services, interact with the db, and then
 * confirm the results.
 */
class FunctionalTestCase extends TestCase {

	/**
	 * Credentials
	 */
	public static function credentials() {
		return json_decode(file_get_contents('./tests/data/credentials.json'), true);
	}
}