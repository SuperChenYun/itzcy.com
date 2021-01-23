<?php
declare(strict_types=1);


use app\service\SettingService;

class TestSettingService extends TestCase
{
    /**
     * @var SettingService
     */
    private $settingService;
    /**
     * @var mixed
     */
    private $article;
    
    public function __construct ($name = null, array $data = [], $dataName = '')
    {
        parent ::__construct($name, $data, $dataName);
        $this -> settingService = new SettingService(new \app\Request());
    }
    
    /**
     * @test
     */
    public function set ()
    {
        $settingModel = $this -> settingService -> set('PHPUNIT_TEST', time(), 'json_encode', ['a' => 'b']);
        
        $this -> assertTrue(
            $settingModel
        );
    }
    
    /**
     * @test
     * @depends set
     */
    public function get ()
    {
        
        $settingModel = $this -> settingService -> get('PHPUNIT_TEST', 'json_decode');
        $this -> assertIsObject($settingModel);
        $this -> assertTrue($settingModel instanceof \app\model\SettingModel);
        $this -> assertArrayHasKey('extend', $settingModel -> toArray(), );
        
    }
    
    /**
     * @test
     */
    public function listTag ()
    {
        $count = \app\model\SettingModel ::where(['delete_time' => 0]) -> count();
        
        $list = $this -> settingService -> lists();
        
        $this -> assertTrue($count == count($list));
    }
    
}