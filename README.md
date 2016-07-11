# Temple

> Actually use PHP as a template engine.

## Usage

```php
use Temple\Temple;

function t($selector, $attrs = null, $children = null) {
  return Temple::t($selector, $attrs, $children);
}

function State() {
  return [
    'title' => [
      'punch' => 'Temple',
      'sub' => 'Actually use PHP as a <strong>template engine</strong>',
    ],

    'navItems' => [
      [ 'to' => '#', title => 'Contacts' ],
      [ 'to' => '#', title => 'Terms' ],
      [ 'to' => '#', title => 'About' ],
    ],
  ];
}

function TmplSection($props, $children) {
  $fullWidth = isset($props['fullWidth']) && $props['fullWidth'];
  $inner = $fullWidth ? $children : t('.tmpl-container', $children);

  return t('.tmpl-section .tmpl-section--' . $props['name'], $inner);
}

function TmplNavItem($props) {
  return (
    t('.tmpl-nav-item', [
      t('a', [ 'href' => $props['to'] ], $props['title']),
    ])
  );
}

function TmplWrap($state) {
  $title = $state['title'];

  return (
    t('.tmpl-wrap', [
      TmplSection([ 'name' => 'header' ], [
        t('.tmpl-header-brand', [
          t('a', [ 'href' => '#' ], [
            t('h1.tmpl-header-brand__punch', $title['punch']),
            t('p.tmpl-header-brand__sub', Temple::trust($title['sub'])),
          ]),
        ]),
      ]),

      TmplSection([ 'fullWidth' => true, 'name' => 'feature' ], [
        t('img.tmpl-parallax', [ 'src' => 'https://placehold.it/1920x1080' ]),
      ]),

      TmplSection([ 'name' => 'footer' ], [
        array_map(TmplNavItem, $state['navItems']),
      ]),
    ])
  );
}

$state = State();
$root = TmplWrap($state);

echo '<!DOCTYPE html>';
echo '<meta charset="utf-8" />';
echo '<title>Temple</title>';
echo '<script>window.__INITIAL_STATE__ = ' . json_encode($state) . '</script>';
echo '<div id="app">';
echo Temple::stringify($root);
echo '</div>';
echo "\n";
```

See more in `Temple.spec.php` and the `Examples` directory.

## How to structure your application

Temple is not a framework. It does not require you to extend its classes or use
organize your code in another specific way. You may however find it convenient
to store parameterized snippets as static methods, with an associative array
of props as the first argument, and a sequential array of child nodes as the
second. If there is always one prop only, you might pass it and not the array
to avoid boilerplate.

## Motivation

> http://mithril.js.org/

Temple is inspired by the view API of Mithril. Write your templates in the same
language as the rest of your application. Catch syntax errors at compile time.
Get minified output by not introducing whitespace rather than removing it.
