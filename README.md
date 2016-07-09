# Temple

> Actually use PHP as a template engine.

## Usage

```php
use function Temple\stringify;
use function Temple\t;

function State() {
  return [
    'title' => [
      'punch' => 'Temple',
      'sub' => 'Actually use PHP as a template engine',
    ],
  ];
}

function TmplWrap($state) {
  $title = $state['title'];

  return (
    t('.tmpl-wrap', [
      t('.tmpl-container', [
        t('.tmpl-header', [
          t('.tmpl-header-brand', [
            t('div.tmpl-header-brand-title', [
              t('a', [ 'href' => '#' ], [
                t('h1.tmpl-header-brand-title__punch', $title['punch']),
                t('p.tmpl-header-brand-title__sub', $title['sub']),
              ]),
            ]),
          ]),
        ]),
      ]),
    ])
  );
}

$state = State();
$root = TmplWrap($state);

echo '<!DOCTYPE html>';
echo '<meta charset="utf-8" />';
echo '<title>Temple</title>';
echo stringify($root);
echo '<script>window.__INITIAL_STATE__ = ' . json_encode($state) . '</script>';
echo "\n";
```

See more in `Temple.spec.php` and the `Examples` directory.

## Motivation

> http://mithril.js.org/

Temple is inspired by the view API of Mithril. Write your templates in the same
language as the rest of your application. Catch syntax errors at compile time.
Get minified output by not introducing whitespace rather than removing it.
