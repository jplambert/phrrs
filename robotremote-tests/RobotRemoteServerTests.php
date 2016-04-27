<?php

use \PhpRobotRemoteServer\RobotRemoteServer;

class RobotRemoteServerTests extends PHPUnit_Framework_TestCase {

    protected function setUp()
    {

    }

    protected function tearDown()
    {

    }

    private function checkRpcCall($rpcRequest, $expectedRpcAnswer) {
        $server = new RobotRemoteServer();
        $server->init(__DIR__.'/test-libraries');

        $inputStream = fopen('data://text/plain;base64,'
                . base64_encode($rpcRequest), 'r');
        $outputStream = fopen('php://memory', 'w');
        $server->execRequest($inputStream, $outputStream);

        rewind($outputStream);
        $result = stream_get_contents($outputStream);
        $this->assertEquals($expectedRpcAnswer, $result);
    }

    public function testGetKeywordNames()
    {
        $this->checkRpcCall('<?xml version="1.0"?>
            <methodCall>
               <methodName>get_keyword_names</methodName>
               <params>
                  </params>
               </methodCall>', '<?xml version="1.0"?>
<methodResponse>
<params>
<param>
<value><array>
<data>
<value><string>truth_of_life</string></value>
<value><string>strings_should_be_equal</string></value>
</data>
</array></value>
</param>
</params>
</methodResponse>');
    }

    public function testRunKeyword()
    {
        $this->checkRpcCall('<?xml version="1.0"?>
            <methodCall>
               <methodName>run_keyword</methodName>
               <params>
                  <param><value><string>truth_of_life</string></value></param> 
                  <param><value><array><data></data></array></value></param> 
               </params>
               </methodCall>', '<?xml version="1.0"?>
<methodResponse>
<params>
<param>
<value><struct>
<member><name>return</name>
<value><int>42</int></value>
</member>
<member><name>status</name>
<value><string>PASS</string></value>
</member>
<member><name>output</name>
<value><string></string></value>
</member>
<member><name>error</name>
<value><string></string></value>
</member>
<member><name>traceback</name>
<value><string></string></value>
</member>
</struct></value>
</param>
</params>
</methodResponse>');
    }

}
