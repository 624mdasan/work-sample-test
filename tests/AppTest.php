<?php

use PHPUnit\Framework\TestCase;

require 'src/App.php';


class AppTest extends TestCase
{
    public function testDo()
    {
        $app = new App();

        echo $app->do();

        $this->assertSame(1,1);
    }
}
