<?php

use App\classes\User;
use PHPUnit\Framework\TestCase;
class UserTest extends TestCase {
    public function testThatWeCanGetTheFirstName() {
        $user = new User(1, "Billy", "Jones", "Tech", "billyjones@gmail.com", "Tech Lead");

        self::assertNotEmpty($user);
        
        // $user->setName('Billy');

        $this->assertEquals($user->getFirstName(), 'Billy');
    }
}

?>