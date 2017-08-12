<?php

require __DIR__ . '/../../domain/chatroom.php';
class chatroomTest extends \Codeception\Test\Unit
{
    protected $harness;
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->harness = new \domain\chatroom();
    }

    protected function _after()
    {
        unset($this->harness);
    }

    // tests
    public function testChatroomName()
    {
        $this->assertClassHasAttribute('members', 'domain\chatroom', 'Missing Userlist');
        $this->assertClassHasAttribute('subject', 'domain\chatroom', 'missing subject');
        $this->assertClassHasAttribute('messages', 'domain\chatroom', 'Missing Messages');
        $this->assertClassHasAttribute('uuid', 'domain\chatroom', 'missing uuid');
        $this->assertClassHasAttribute('owners', 'domain\chatroom', 'missing owner');
        $this->assertClassHasAttribute('name', 'domain\chatroom', 'missing name');
        $this->assertClassHasAttribute('lastActive', 'domain\chatroom', 'missing lastActive');
        $this->assertClassHasAttribute('created', 'domain\chatroom', 'missing created');

        $expected = 'Bobship';
        $this->harness->setName($expected);
        $actule = $this->harness->name();

        $this->assertEquals($expected, $actule);
    }

    public function testChatroomSubject()
    {
        $expected = 'Some ugly shit is going down in here';

        $this->harness->setSubject($expected);
        $act = $this->harness->subject();

        $this->assertEquals($expected, $act);
    }

    public function testChatroomOwner()
    {
        $mem = new \domain\user();
        $mem->setUsername('somestring');
        $expect = [$mem];

        $this->harness->addOwner($mem);
        $act =  $this->harness->owners();

        $this->assertEquals($expect, $act);

        $mem2 = new \domain\user();
        $mem2->setUsername('Sweet');

        $this->harness->addOwner($mem2);
        $expect[] = $mem2;
        $act = $this->harness->owners();
        $this->assertEquals($expect, $act);
    }

    public function testChatroomRemoveOwner()
    {
        $mem = new \domain\user();
        $mem->setUsername('somestring');
        $expect = [$mem];

        $this->harness->addOwner($mem);
        $act =  $this->harness->owners();

        $this->assertEquals($expect, $act);

        $mem2 = new \domain\user();
        $mem2->setUsername('Sweet');

        $this->harness->addOwner($mem2);
        $expect[] = $mem2;
        $act = $this->harness->owners();
        $this->assertEquals($expect, $act);

        unset($expect);
        $ok = $this->harness->removeOwner($mem);
        $this->assertEquals(true, $ok);
        $expect = [$mem2];

        //$act = $this->harness->owners();

        //$this->assertEquals($expect,$act);
    }

    public function testChatroomJoin()
    {
        $mem1 = new \domain\user();
        $mem2 = new \domain\user();
        $mem3 = new \domain\user();

        $this->harness->join($mem1);
        $this->harness->join($mem2);
        $this->harness->join($mem3);

        $expect = [$mem1, $mem2, $mem3];
        $act = $this->harness->members();

        $this->assertEquals($expect, $act);
    }

    public function testChatroomID()
    {
        $expect = 1;
        $this->harness->setChatroomid($expect);

        $act = $this->harness->chatroomid();
        $this->assertEquals($expect, $act);
    }

    public function testChatroomLeave()
    {
        $mem1 = new \domain\user();
        $mem2 = new \domain\user();
        $mem3 = new \domain\user();

        $this->harness->join($mem1);
        $this->harness->join($mem2);
        $this->harness->join($mem3);

        $expect = [$mem1, $mem2, $mem3];
        $act = $this->harness->members();

        $this->assertEquals($expect, $act);


        $ok = $this->harness->leave($mem2);
        $this->assertEquals(true, $ok);
        $act = $this->harness->members();
        //$expect = [$mem1,$mem3];


        //$this->assertEquals($expect, $act);
    }
}
