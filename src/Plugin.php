<?php

namespace TheLookAndFeel\ExternalSystemLinksAppPresser;

class Plugin
{
    /** @var Filter */
    public $filter;

    public function __construct()
    {
        $this->filter = new Filter();
    }

    public function setup()
    {
        $this->filter->urls    = apply_filters('tlaf_appp_esl_allowed_urls', [site_url()]);
        $this->filter->classes = apply_filters('tlaf_appp_esl_applied_classes', ['external', 'system']);

        add_filter('the_content', [$this->filter, 'contentFilter'], 10, 1);
    }
}