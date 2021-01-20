<?php
declare(strict_types=1);

class Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function demo()
    {
        $this->assertNotEquals('0', time());
        return true;
    }
    
    
}