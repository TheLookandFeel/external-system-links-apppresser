<?php

use TheLookAndFeel\ExternalSystemLinksAppPresser\Filter;

class FilterTest extends PHPUnit_Framework_TestCase {
    /** @test */
    public function it_doesnt_change_content_without_link_elements() {
        $content = '<p>Hello world, this is an example text without any link elements.</p>';

        $filter = new Filter();
        $filter->classes = ['test'];
        $filter->urls = ['http://thelookandfeel.no'];

        $this->assertContains($content, $filter->contentFilter($content));
    }

    /** @test */
    public function it_adds_classes_to_link_elements_without_whitelisted_hrefs() {
        $content = '<p>Hello world, this is an example text with a <a href="http://www.google.com">link element</a>.</p>';
        $expected = '<a href="http://www.google.com" class="test">link element</a>';

        $filter = new Filter();
        $filter->classes = ['test'];
        $filter->urls = ['http://thelookandfeel.no'];

        $this->assertContains($expected, $filter->contentFilter($content));
    }

    /** @test */
    public function it_doesnt_adds_classes_to_whitelisted_link_elements() {
        $content = '<p>Hello world, this is an example text with a <a href="http://thelookandfeel.no">link element</a>.</p>';
        $expected = '<a href="http://thelookandfeel.no">link element</a>';

        $filter = new Filter();
        $filter->classes = ['test'];
        $filter->urls = ['http://thelookandfeel.no'];

        $this->assertContains($expected, $filter->contentFilter($content));
    }

    /** @test */
    public function it_adds_classes_to_non_whitelisted_links_in_mixed_content() {
        $content = '<p>Hello world, this is an example text with a <a href="http://thelookandfeel.no">link element</a>.</p>';
        $content .= '<p>This is another example with a <a href="http://google.com">link element</a>.</p>';

        $expected_without_classes = '<a href="http://thelookandfeel.no">link element</a>';
        $expected_with_classes = '<a href="http://google.com" class="test">link element</a>';

        $filter = new Filter();
        $filter->classes = ['test'];
        $filter->urls = ['http://thelookandfeel.no'];

        $filtered = $filter->contentFilter($content);
        $this->assertContains($expected_without_classes, $filtered);
        $this->assertContains($expected_with_classes, $filtered);
    }
}