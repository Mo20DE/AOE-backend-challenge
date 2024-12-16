<?php

require_once "./backend/src/encrypt.php";
use \PHPUnit\Framework\TestCase;

class EncryptionTest extends TestCase {

    public function testEncryption() {
        
        // test empty strings and strings with whitespace
        $this->assertSame("", deeSeeChiffre("", 0));
        $this->assertSame("", deeSeeChiffre("", 3));
        $this->assertSame(" ", deeSeeChiffre(" ", 0));
        $this->assertSame(" ", deeSeeChiffre(" ", 3));

        // test basic and complex cases
        $this->assertSame("clark kent", deeSeeChiffre("clark kent", 0));
        $this->assertSame("fodun nhqw", deeSeeChiffre("clark kent", 3));
        $this->assertSame("clark kent", deeSeeChiffre("clark kent", 26));
        $this->assertSame("fodun nhqw", deeSeeChiffre("clark kent", 29));
        $this->assertSame("hmjwwd gqtxxtr", deeSeeChiffre("cherry blossom", 5));
        $this->assertSame("bcpstlsri", deeSeeChiffre("xylophone", 4));
    }
}
?>
