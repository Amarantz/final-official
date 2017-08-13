<?php


use settings;

class settingsCest
{
    protected $settings;

    /**
     * @param UnitTester $I
     */
    public function _before(UnitTester $I)
    {
    }

    /**
     * @param UnitTester $I
     */
    public function _after(UnitTester $I)
    {
    }

    // tests

    /**
     * @param UnitTester $I
     */
    public function tryToTest(UnitTester $I)
    {
        $set = new settings();
        $I->assertTrue(isset($set));
        $db = $set->getConf();
        $I->assertArrayHasKey($db['dsn'], 'mysql:host=localhost;dbname=test;port=3306');
        $I->assertArrayHasKey($db['user'], 'foo');
        $I->assertArrayHasKey($db['pass'], 'bar');
    }
}
