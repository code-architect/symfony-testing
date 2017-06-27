<?php


namespace AppBundle\Twig;


use AppBundle\Service\MarkDownTransformer;

class MarkdownExtension extends \Twig_Extension
{
    /**
     * @var MarkDownTransformer
     */
    private $markDownTransformer;

    public function __construct(MarkDownTransformer $markDownTransformer)
    {

        $this->markDownTransformer = $markDownTransformer;
    }


    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdownify', [$this, 'parseMarkdown'], [
                'is_safe' => ['html']
            ])
        ];
    }



    public function parseMarkdown($str)
    {
        return $this->markDownTransformer->parse($str);
    }



    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_markdown';
    }
}