# External System Links for AppPresser

[![Build Status](https://img.shields.io/travis/TheLookandFeel/external-system-links-apppresser.svg?style=flat-square)](https://travis-ci.org/TheLookandFeel/external-system-links-apppresser)

WordPress plugin: Filters external links in post content to give them 'external system' classes, to have AppPresser handle them as links opening in the system browser. The added classes and allowed (non-external) URLs are filterable.

Using these classes can be found in the AppPresser documentation on [In App Browser Links](http://docs.apppresser.com/article/201-in-app-browser-links). This plugin will default to opening all external links in the systems default browser.

## Available WordPress filters
- `tlaf_appp_esl_allowed_urls` allows you to change the URLs that don't get the extra classes applied. This defaults to just include the site URL.
- `tlaf_appp_esl_applied_classes` allows you to change the classes that will be applied to external links. Defaults to an array containing `external` and `system` (as per the AppPresser documentation).