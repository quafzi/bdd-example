<?php

class Parser
{
    const MODE_P  = 'p';
    const MODE_H1 = 'h1';
    const MODE_H2 = 'h2';
    const MODE_H3 = 'h3';
    const MODE_H4 = 'h4';
    const MODE_UL = 'ul';

    protected $mode = self::MODE_P;
    protected $paragraph = array();
    protected $headlines = array();

    protected static $headlineTriggers = array(
        "=",
        "-",
        "~",
        "#",
        "'"
    );
    protected static $listTriggers = array('*');

    public function run($rst)
    {
        $html = '';
        $this->paragraph = array();
        $this->headlines = array();

        $lines = explode("\n", $rst);
        $lines[] = ''; // add an empty line to the bottom

        foreach ($lines as $no=>$line) {
            if (0 == strlen(trim($line)) && count($this->paragraph)) {
                $html .= sprintf(
                    '<%s>%s</%s>',
                    $this->mode,
                    implode('', $this->paragraph),
                    $this->mode
                );
                $this->paragraph = array();
                $this->mode = self::MODE_P;
            }
            if (strlen(trim($line))) {
                // starting a new paragraph
                $firstChar = substr($line, 0, 1);
                if (in_array($firstChar, self::$headlineTriggers)) {
                    if (false == array_key_exists($firstChar, $this->headlines)) {
                        $this->headlines[$firstChar] = count($this->headlines) + 1;
                    }
                    $this->mode = 'h' . $this->headlines[$firstChar];
                } elseif (in_array($firstChar, self::$listTriggers)) {
                    $this->mode = self::MODE_UL;
                    $this->paragraph[] = '<li>' . trim(substr($line, 1)) . '</li>';
                } else {
                    $this->paragraph[] = $line;
                }
            }
        }
        return $html;
    }
}
