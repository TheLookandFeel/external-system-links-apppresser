<?php

namespace TheLookAndFeel\ExternalSystemLinksAppPresser;

use DOMDocument;
use DOMElement;

class Plugin
{
    /** @var array */
    public $urls = [];

    /** @var array */
    public $applied_classes = [];

    public function setup()
    {
        add_filter('the_content', [$this, 'contentFilter'], 10, 1);

        $this->urls            = apply_filters('tlaf_appp_esl_allowed_urls', [site_url()]);
        $this->applied_classes = apply_filters('tlaf_appp_esl_applied_classes', ['external', 'system']);
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function contentFilter($content)
    {
        $dom = new DOMDocument;
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

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
        $classes = explode(' ', $node->getAttribute('class'));
        $classes = implode(' ', array_unique(array_merge($classes, $this->applied_classes)));
        $node->setAttribute('class', $classes);

        return $node;
    }
}