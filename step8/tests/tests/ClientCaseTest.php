<?php

/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
require __DIR__ . "/../../vendor/autoload.php";

class ClientCaseTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $row = array(
            'id' => 23,
            'client' => 9,
            'clientName' => "Simpson, Bart",
            'agent' => 8,
            'agentName' => "Owen, Charles",
            'summary' => "This is a summary",
            'status' => 'O',
            'number' => '16-1234'
        );

        $case = new Felis\ClientCase($row);
        $this->assertEquals($row['id'], $case->getId());
        $this->assertEquals($row['client'], $case->getClient());
        $this->assertEquals($row['clientName'], $case->getClientName());
        $this->assertEquals($row['agent'], $case->getAgent());
        $this->assertEquals($row['agentName'], $case->getAgentName());
        $this->assertEquals($row['summary'], $case->getSummary());
        $this->assertEquals($row['status'], $case->getStatus());
        $this->assertEquals($row['number'], $case->getNumber());
    }
}

/// @endcond
