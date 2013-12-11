TextFilter
==========

This library provides a standard interface (`TheWilkyBarKid\TextFilter\TextFilter`) for text filters. The interface defines a single method, `filter()`, which takes a string and returns a (presumably modified) string.

That in itself isn't particularly useful, but it does open up some interesting possibilities.

It also provides some adapters, allowing you to indirectly use libraries through the interface.

Chaining filters
----------------

The `TheWilkyBarKid\TextFilter\TextFilterChain` class takes any number of text filters and runs through them one after another (in a user-controlled order).

This allows you to build a potentially-lengthy chain of filters, simplifying your logic when actually using them:

    $filter = new TextFilterChain(array($markdownFilter, $smartyPantsFilter, $htmlPurifierFilter));

    // later on
    $output = $filter->filter('some markdown');

Caching filters
---------------

Normally you should persist the result of your filters alongside the plain input to avoid running it through potentially expensive filters at runtime. As this isn't always possible, the `TheWilkyBarKid\TextFilter\DoctrineCacheTextFilterWrapper` class wraps a text filter and caches the result in a Doctrine cache driver (file-based, Memcache, Redis etc).

    $chain = new TextFilterChain(array($markdownFilter, $smartyPantsFilter, $htmlPurifierFilter));
    $filter = new DoctrineCacheTextFilterWrapper($cache, $chain));
