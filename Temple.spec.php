<?php
require_once(dirname(__FILE__) . '/Temple.php');
use function Temple\stringify;
use function Temple\t;

require_once(dirname(__FILE__) . '/Examples/TodoApp.php');
use function Temple\Examples\TodoApp\State;
use function Temple\Examples\TodoApp\TodoApp;

function it($message, $assertion) {
  echo '[' . ($assertion ? 'x' : ' ') . '] ' . $message . "\n";
}

//

echo '# Temple' . "\n\n";

//

echo '## t($selector, $attrs?, $children?)' . "\n\n";

//

$root = t('div', 'Hello world');
$expected = '<div>Hello world</div>';

$result = stringify($root);
it('creates `div` with text', $result === $expected);

//

$root = t('div', [
  'Hello world',
]);
$expected = '<div>Hello world</div>';

$result = stringify($root);
it('creates `div` with text[1]', $result === $expected);

//

$root = t('div', [
  'Hello',
  ' ',
  'world',
]);
$expected = '<div>Hello world</div>';

$result = stringify($root);
it('creates `div` with text[3]', $result === $expected);

//

$root = t('a', [ 'href' => 'about:blank' ], 'Home');
$expected = '<a href="about:blank">Home</a>';

$result = stringify($root);
it('creates `a` with `href` and text', $result === $expected);

//

$isBig = true;
$root = t('.tmpl-hr' . ($isBig ? '.tmpl-hr--big' : ''));
$expected = '<div class="tmpl-hr' . ($isBig ? ' tmpl-hr--big' : '') . '"></div>';

$result = stringify($root);
it('creates `div` (explicitly) with classes', $result === $expected);

//

$isBig = true;
$root = t('.tmpl-hr' . ($isBig ? '.tmpl-hr--big' : ''));
$expected = '<div class="tmpl-hr' . ($isBig ? ' tmpl-hr--big' : '') . '"></div>';

$result = stringify($root);
it('creates `div` (implicitly) with classes', $result === $expected);

//

echo "\n";
echo '## stringify($node)' . "\n\n";

//

$root = (
  t('.tmpl-wrap', [
    t('.tmpl-container', [
      t('.tmpl-header', [
        t('.tmpl-header-brand', [
          t('div.tmpl-header-brand-title', [
            t('a', [ 'href' => '#' ], [
              t('h1.tmpl-header-brand-title__punch', 'Temple'),
              t('p.tmpl-header-brand-title__sub', 'Actually use PHP as a template engine'),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
);

$expected = implode('', [
  '<div class="tmpl-wrap">',
  '<div class="tmpl-container">',
  '<div class="tmpl-header">',
  '<div class="tmpl-header-brand">',
  '<div class="tmpl-header-brand-title">',
  '<a href="#">',
  '<h1 class="tmpl-header-brand-title__punch">',
  'Temple',
  '</h1>',
  '<p class="tmpl-header-brand-title__sub">',
  'Actually use PHP as a template engine',
  '</p>',
  '</a>',
  '</div>',
  '</div>',
  '</div>',
  '</div>',
  '</div>',
]);

$result = stringify($root);
it('serializes nested structure created with t()', $result === $expected);

//

$state = State();
$root = TodoApp($state);

$expected = implode('', [
  '<div class="todo-app">',
  '<form class="todo-form">',
  '<input placeholder="Create a todo" title="Todo text" type="text" class="todo-form-control">',
  '</input>',
  '<button type="submit">',
  'Submit',
  '</button>',
  '</form>',
  '<div class="todo-list">',
  '<div class="todo-list-entry">',
  '<label class="todo-list-entry-inner">',
  '<input checked type="checkbox" class="todo-list-entry-done">',
  '</input> ',
  '<span class="todo-list-entry">',
  'Wake up',
  '</span>',
  '</label>',
  '</div>',
  '<div class="todo-list-entry">',
  '<label class="todo-list-entry-inner">',
  '<input type="checkbox" class="todo-list-entry-done">',
  '</input> ',
  '<span class="todo-list-entry">',
  'Drink coffee',
  '</span>',
  '</label>',
  '</div>',
  '<div class="todo-list-entry">',
  '<label class="todo-list-entry-inner">',
  '<input checked type="checkbox" class="todo-list-entry-done">',
  '</input> ',
  '<span class="todo-list-entry">',
  'Take shower',
  '</span>',
  '</label>',
  '</div>',
  '</div>',
  '</div>',
]);

$result = stringify($root);
it('serializes the TodoApp example', $result === $expected);

//

$paragraphs = [
  'Portland tofu paleo locavore, farm-to-table four dollar toast godard shabby chic knausgaard dreamcatcher.',
  'Gochujang shoreditch messenger bag migas, portland VHS kinfolk farm-to-table sustainable schlitz pour-over fixie beard bitters organic.',
  'Ugh photo booth retro, tacos bespoke twee kickstarter truffaut polaroid vice organic williamsburg blue bottle.',
];

$root = (
  t('article', [
    t('h1', 'Seitan taxidermy art party letterpress whatever'),
    array_map(function ($paragraph) {
      return t('p', $paragraph);
    }, $paragraphs),
    t('p.more', [
      t('a', [ 'href' => '#' ], 'Read more'),
    ]),
  ])
);

$expected = implode('', [
  '<article>',
  '<h1>',
  'Seitan taxidermy art party letterpress whatever',
  '</h1>',
  '<p>',
  'Portland tofu paleo locavore, farm-to-table four dollar toast godard shabby chic knausgaard dreamcatcher.',
  '</p>',
  '<p>',
  'Gochujang shoreditch messenger bag migas, portland VHS kinfolk farm-to-table sustainable schlitz pour-over fixie beard bitters organic.',
  '</p>',
  '<p>',
  'Ugh photo booth retro, tacos bespoke twee kickstarter truffaut polaroid vice organic williamsburg blue bottle.',
  '</p>',
  '<p class="more">',
  '<a href="#">',
  'Read more',
  '</a>',
  '</p>',
  '</article>',
]);

$result = stringify($root);
it('allows array as a child', $result === $expected);
