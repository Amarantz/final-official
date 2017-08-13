<?php

require __DIR__ . '/../../domain/message.php';
//require __DIR__ . '/../../domain/user.php';
class messageTest extends \Codeception\Test\Unit
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
    public function testMessageClass()
    {
        $obj = new \domain\message();

        $this->assertClassHasAttribute("userID", "domain\message", "Message Class");
        $this->assertClassHasAttribute("timestamp", "domain\message", "Message Class");
        $this->assertClassHasAttribute("message", "domain\message", "message Class has a Message variable");
        $this->assertClassHasAttribute('messageID', "domain\message", 'Needs a messageID');

        $user = new \domain\user();

        $user->setUsername("Bobsimpsons")->setEmail("email@email.com")->setUserID(1);
        $obj->setUser($user);
        try {
            $time = new DateTime();

            $obj->setTimeStamp(date('Y-m-d H:i:s'));
        } catch (\Exception $e) {
            $this->assertEquals('Time stamp is not set', $e->getMessage());
        }
        $obj->setMessage('This is some Message we might want to string shit.');
        $obj->setMessageID(1);
        $user = null;
        $this->assertNull($user);
        //checks if the users object is set with the message class.
        $this->assertEquals("Bobsimpsons", $obj->getUser()->getUsername());
        $this->assertEquals("This is some Message we might want to string shit.", $obj->getMessage());
        $this->assertStringMatchesFormat('%s', $obj->getTimestamp());
        $this->assertEquals('1', $obj->getMessageID());
    }
}
