<?php

class indexTest extends PHPUnit_Framework_TestCase
	{
	public function testSiteIndex()
		{
		ob_start();
		include('www/index.php');
		$output = ob_get_clean();
		ob_end_clean();
        $a = new HelpScoutTagline();
        $tagline = $a->gettagline();

		$this->assertSame("Automation for the people", $tagline);
		}
	}

?>


<?php
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    // ...

    public function testCanBeNegated()
    {
        // Arrange
        $a = new Money(1);

        // Act
        $b = $a->negate();

        // Assert
        $this->assertEquals(-1, $b->getAmount());
    }

    // ...
}
