<?php

use Petflow\Testing\TestCase;
use Petflow\Signifyd\Investigation,
    Petflow\Signifyd\Client\Signifyd;

/**
 * An investigation test.
 */
class InvestigationTest extends TestCase {

    /**
     * Setup this test case, with a signifyd client mock.
     */
    public function setUp() {
        $this->http = Mockery::mock('Guzzle\Http\Client');

        // create the signifyd object
        $this->signifyd = new Signifyd('example-key');
        $this->signifyd->set($this->http);

        // now the investigation object
        $this->investigation = new Investigation(array('key' => 'example-key'));
        $this->investigation->setClient($this->signifyd);

        // an http response
        $this->response = Mockery::mock('Guzzle\Http\Message\Response');
    }

    /**
     * Test creating a new fraud case returns the case id.
     * 
     * @return null
     */
    public function testCreateFraudCaseReturnsCaseId() {
        $data = array();

        // mock the post
        $this->http->shouldReceive('post')
            ->with('cases', null, json_encode($data))
            ->once()
            ->andReturn(
                Mockery::mock('stdClass')
                    ->shouldReceive('send')
                    ->once()
                    ->andReturn($this->response)
                    ->getMock()
            );

        // mock the response success
        $this->response->shouldReceive('isSuccessful')
            ->once()
            ->andReturn(true);

        // mock the response content
        $this->response->shouldReceive('json')
            ->once()
            ->andReturn(
                array('investigationId' => 123456)
            );

        $result = $this->investigation->post($data);

        $this->assertTrue($result['success']);
        $this->assertEquals(123456, $result['case_id']);
    }

    /**
     * Test retrieving a fraud case returns an array.
     * 
     * @return null
     */
    public function testRetrieveFraudCaseReturnsArray() {
        $case_id = 7891011;
        $data    = array(
            'orderId'         => 123456,
            'investigationId' => $case_id,
            'scoreCategory'   => 'warning',
            'adjustedScore'   => '430'
        );

        // mock the get
        $this->http->shouldReceive('get')   
            ->with('cases/'.$case_id)
            ->once()
            ->andReturn(
                Mockery::mock('stdClass')
                    ->shouldReceive('send')
                    ->once()
                    ->andReturn($this->response)
                    ->getMock()
            );

        // mock the response
        $this->response->shouldReceive('isSuccessful')
            ->once()
            ->andReturn(true);

        // mock the response content
        $this->response->shouldReceive('json')
            ->once()
            ->andReturn($data);

        $result = $this->investigation->get($case_id);

        $this->assertTrue($result['success']);
        $this->assertEquals($data, $result['response']);
    }

    public function testRetrieveCaseByOrderIdReturnsArray() {
        $order_id = 123456;
        $data     = array(
            'orderId'         => $order_id,
            'investigationId' => 7891011,
            'scoreCategory'   => 'warning',
            'adjustedScore'   => '430'
        );

        // mock the get
        $this->http->shouldReceive('get')   
            ->with('orders/'.$order_id.'/case')
            ->once()
            ->andReturn(
                Mockery::mock('stdClass')
                    ->shouldReceive('send')
                    ->once()
                    ->andReturn($this->response)
                    ->getMock()
            );

        // mock the response
        $this->response->shouldReceive('isSuccessful')
            ->once()
            ->andReturn(true);

        // mock the response content
        $this->response->shouldReceive('json')
            ->once()
            ->andReturn($data);

        $result = $this->investigation->getByOrderId($order_id);

        $this->assertTrue($result['success']);
        $this->assertEquals($data, $result['response']);
    }
}