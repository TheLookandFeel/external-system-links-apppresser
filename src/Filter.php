<?php

namespace TheLookAndFeel\ExternalSystemLinksAppPresser;

use DOMDocument;
use DOMElement;

class Filter
{
    /** @var array */
    public $urls = [];

    /** @var array */
    public $classes = [];

    /**
     * @param string $content
     *
     * @return string
     */
    public function contentFilter($content)
    {
        $dom = new DOMDocument;
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($dom->getElementsByTagName('a') as $node) {
            $this->handleElement($node);
        }

        return $dom->saveHTML();
    }

    /**
     * @param DOMElement $node
     *
     * @return mixed
     */
    public function handleElement(DOMElement $node)
    {
        $add_classes = true;
        $href        = $node->getAttribute('href');

        foreach ($this->urls as $url) {
            if (strstr($href, $url) !== false) {
                $add_classes = false;
                break;
            }
        }

        if ( ! $add_classes) {
            return;
        }

        $this->addClasses($node);
    }

    /**
     * @param DOMElement $node
     *
     * @return DOMElement
     */
    public function addClasses(DOMElement $node)
    {
        $classes = array_filter(explode(' ', $node->getAttribute('class')));
        $classes = implode(' ', array_unique(array_merge($classes, $this->classes)));
        $node->setAttribute('class', $classes);

        return $node;
    }
}