<?php

use Infustructure\Storage\Client\MysqlAdapter;
require __DIR__.'/../../infustructure/storage/Client/MysqlAdapter.php';
class clientTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $db = new PDO('mysql:host=localhost;dbname=cs3620;port=3306', 'fo1', 'bar');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->tester = new MysqlAdapter($db);
    }

    protected function _after()
    {
        unset($this->tester);
    }

    // tests
    public function testValidateAPIKEY()
    {
        $key = '7d32fdc7-a36c-a1b1-5bc0223a457c';
        $this->assertTrue($this->tester->isValidKey($key));
        $key = 'afaaaaf adfa';
        $this->assertFalse($this->tester->isValidKey($key));

    }
}
