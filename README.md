Signifyd
========
[![Build Status](https://travis-ci.org/petflow/signifyd.svg?branch=master)](https://travis-ci.org/petflow/signifyd)
[![Coverage Status](https://coveralls.io/repos/petflow/signifyd/badge.png?branch=master)](https://coveralls.io/r/petflow/signifyd?branch=master)

Signifyd is a third party solution for detecting fraud in e-commerce transactions, available as a RESTful API. This library is a simple wrapper for their API service, using the Guzzle http library to make requests and handle responses.

For more information about Signifyd and their API, see links below:
* https://www.signifyd.com
* https://www.signifyd.com/docs/api

## Usage

#### Basic Case Operations
~~~php
$investigation = new Investigation('your-signifyd-api-key-here');

// fields match exactly to reference: https://www.signifyd.com/docs/api
$data = array(
    'purchase' => array(...),
    'card'     => array(...),
    ...
);

// create a new case
$result = $investigation->post($data);

// retrieve a case
$result = $investigation->get($result['case_id']);

if ($result['success']) {
    $score = $case['response']['adjustedScore'];   
}
~~~

#### Handling Errors
~~~php
$result = $investigation->post($data);

if (!$result['success']) {
    // unsuccessful
    $reason = $result['reason'];

} else {
    // successful
}
~~~

## FAQ

#### What is / where can I get a Signifyd API key?
The API key is used in Basic HTTP authentication to identify who you are to their service. They do not provide a public sandbox, however you may obtain testing keys by contacting them here: https://www.signifyd.com/get-started.