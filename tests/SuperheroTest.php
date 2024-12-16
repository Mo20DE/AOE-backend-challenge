<?php

require_once "./backend/src/Superhero.php";
use \PHPUnit\Framework\TestCase;

class SuperheroTest extends TestCase {

    public  function testSuperhero() {

        $superpowers = ["flight", "strength", "invulnerability"];
        $superhero = new Superhero("superman", "clark", "kent", "1987-05-13", $superpowers);

        // test hero name
        $this->assertEquals("superman", $superhero->getHeroName());

        // test full name
        $this->assertSame("clark kent", $superhero->getFullName());

        // test birthday
        $this->assertSame("1987-05-13", $superhero->getBirthday());

        // test superpowers
        $this->assertSame(implode(", ", $superpowers), $superhero->getSuperpowers());
    }
}
?>
