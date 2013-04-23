<?php

namespace spec;

use PHPSpec2\ObjectBehavior;

class Parser extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Parser');
    }

    function it_should_convert_lists()
    {
        $rst = <<<RST
* foo
* bar
RST;
        $html = '<ul><li>foo</li><li>bar</li></ul>';
        $this->run($rst)->shouldReturn($html);
    }

    function it_should_convert_headlines()
    {
        $markers = array(
            "=-~#'",
            "-~=#'",
            "=~#-'",
            "'=-~#",
            "#~-='",
            "#='~-",
        );

        foreach ($markers as $headlines) {
            $rst = '';
            $headlines = str_split($headlines);
            foreach ($headlines as $offset=>$headline) {
                $rst .= "foo\n" . str_repeat($headline, 3) . "\n";
            }
            $expected = '<h1>foo</h1>'
                . '<h2>foo</h2>'
                . '<h3>foo</h3>'
                . '<h4>foo</h4>'
                . '<h5>foo</h5>';
            $this->run($rst)->shouldReturn($expected);
        }
    }

}
