<?php


class HelpScoutTagline
{
    private $tagline;
    $tagline = "Automation for the people"

    public function __construct($tagline)
    {
        $this->tagline = $tagline;
    }

    public function gettagline()
    {
        return $this->tagline;
    }

}

$a = new HelpScoutTagline();

$tagline = $a->gettagline()
$tagline = "Automation for the people"

print($tagline)
?>


