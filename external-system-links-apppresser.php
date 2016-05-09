<?php

/**
 * Plugin Name: External System Links for AppPresser
 * Description: Filters external links in post content to give them 'external system' classes, to have AppPresser handle them as links opening in the system browser. The added classes and allowed (non-external) URLs are filterable.
 * Author: The Look And Feel
 * Author URI: http://thelookandfeel.no
 */

add_filter( 'the_content', 'tlaf_appp_esl_content_filter', 10, 1 );

function tlaf_appp_esl_content_filter( $content ) {
	$urls            = apply_filters( 'tlaf_appp_esl_allowed_urls', array( site_url() ) );
	$applied_classes = apply_filters( 'tlaf_appp_esl_applied_classes', array( 'external', 'system' ) );

	$dom = new DOMDocument;
	$dom->loadHTML( $content );

	/** @var DOMElement $node */
	foreach ( $dom->getElementsByTagName( 'a' ) as $node ) {
		$add_classes = true;
		$href = $node->getAttribute( 'href' );

		foreach ( $urls as $url ) {
			if ( strstr( $href, $url ) !== false ) {
				$add_classes = false;
				break;
			}
		}

		if ( ! $add_classes ) {
			continue;
		}

		$classes = explode( ' ', $node->getAttribute( 'class' ) );
		$classes = implode( ' ', array_unique( array_merge( $classes, $applied_classes ) ) );
		$node->setAttribute( 'class', $classes );
	}

	return $dom->saveHTML();
}