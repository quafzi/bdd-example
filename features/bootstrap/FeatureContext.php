<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use \Parser;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    protected $parser;
    protected $source;
    protected $result;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
        $this->parser = new Parser();
    }

    /**
     * @Given /^eine RST-Zeichenkette$/
     */
    public function initRst()
    {
        $this->source = <<<RST
Titel1
111111

Das ist ein Test.

Titel2
222222

Mit etwas Text.

Titel3
333333

Was soll ausprobiert werden?

Titel4
444444

storyBDD mit Behat.
RST;
    }

    /**
     * @Given /^das RST enthält eine unnummerierte Liste$/
     */
    public function dasRstEnthaltEineUnnummerierteListe()
    {
        $this->source = str_replace(
            'Das ist ein Test.',
            "* Das\n* ist\n* ein\n* Test.",
            $this->source
        );
    }

    /**
     * @Given /^die HTML-Umwandlung erfolgt$/
     */
    public function dieHtmlUmwandlungErfolgt()
    {
        $this->result = $this->parser->run($this->source);
    }

    /**
     * @Given /^wird eine ul-Liste erzeugt$/
     */
    public function wirdEineUlListeErzeugt()
    {
        $expected = '<ul><li>Das</li><li>ist</li><li>ein</li><li>Test.</li></ul>';
        if (false === strpos($this->result, $expected)) {
            throw new Exception('Die gewünschte Liste wurde nicht gefunden: ' . $this->result);
        }
    }

    /**
     * @Given /^die (\d+)\. Überschrift ist mit (.) markiert$/
     */
    public function dieUberschriftIstMitMarkiert($offset, $marker)
    {
        $this->source = str_replace(
            "Titel$marker",
            "Titel$offset",
            str_replace(
                $offset,
                $marker,
                $this->source
            )
        );
    }

    /**
     * @Given /^wird die (\d+)\. Überschrift mit "([^"]*)" erzeugt$/
     */
    public function wirdDieUberschriftMitErzeugt($offset, $tag)
    {
        $expected = sprintf('<%s>Titel%s</%s>', $tag, $offset, $tag);
        if (false === strpos($this->result, $expected)) {
            throw new Exception("Die $offset. Überschrift wurde nicht mit $tag markiert: " . $this->result);
        }
    }
}
