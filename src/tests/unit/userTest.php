<?php

require  __DIR__ . '/../../domain/user.php';
class userTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testUserObject()
    {
        // creates users object or should
        $user = new \domain\user();
        $this->assertNull($user->getUsername(), "we should have no user name yet");
        $this->assertNull($user->getEmail(), "we should get no email address");
        $this->assertNull($user->getUserID(), "We haven't set a user id");
        $this->assertNotNull($user->getUUID(), "We should have something here");
    }

    public function testSettingUsername()
    {
        $user = new \domain\user();
        try {
            $user->setUserID('string');
        } catch (\Exception $e) {
            $this->assertEquals("not a valid numeric value string", $e->getMessage());
        }

        try {
            $user->setUserID(null);
        } catch (\Exception $e) {
            $this->assertEquals("not a valid numeric value ", $e->getMessage());
        }
        try {
            $user->setUserID(1231);
        } catch (\Exception $e) {
            $this->assertEquals("not a valid numeric value ", $e->getMessage());
        }
        $user->setUsername("SweetKing99");

        $this->assertEquals('1231', $user->getUserID());
        $this->assertNotNull($user->getUsername(), "We should have a usersname");
    }

    public function testTwoUserObjectAreNotTheSame()
    {
        $userA = new \domain\user();
        $userB = new \domain\user();
        $this->assertNotNull($userA->getUUID(), "This should have a value");
        $this->assertNotNull($userB->getUUID(), "This should have a value");

        $this->assertEquals(false, $userA->getUUID() == $userB->getUUID(), "We should have 2 unique IDs");
    }

    public function testSettingEmail()
    {
        $user = new \domain\user();
        try {
            $user->setEmail("we are not a valid email address");
        } catch (\Exception $e) {
            $this->assertEquals("Not a valid email Address", $e->getMessage());
        }

        try {
            $user->setEmail("email@email.com");
        } catch (\Exception $e) {
            $this->assertEquals("Not a valid email Address", $e->getMessage());
        }

        $this->assertEquals("email@email.com", $user->getEmail());
    }

    public function testAll()
    {
        $user = new \domain\user();

        try {
            $user->setUsername("SomeString")->setEmail("email@email.com")->setUserID(12341)->setUUID('12345123aadfa');
        } catch (\Exception $e) {
            $this->assertNotNull($e, "Expected Error has Occurred");
        }
    }
}
