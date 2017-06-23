<?php
/**
 * My custom markdown parser
 */

namespace AppBundle\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkDownTransformer
{
    private $markdownParser;

    // dependency injection for markdown , using MarkdownParserInterface
    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }


    public function parse($str)
    {
        return $funFact = $this->markdownParser
            ->transformMarkdown($str);
    }


}