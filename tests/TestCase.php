<?php


class TestCase extends \PHPUnit\Framework\TestCase
{
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        
        // 执行HTTP应用
        $http = (new \think\App())->http;
        $response = $http->run();
    }
    
    /**
     * @test
     */
    public function jump()
    {
        $this->assertIsBool(true);
    }
}