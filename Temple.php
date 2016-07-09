<?php
namespace Temple;

function isSequential($array) {
  return array_keys($array) === range(0, count($array) - 1);
}

function parseSelector($selector, $attrs) {
  $tag = 'div';
  $class = '';

  $iDot = strpos($selector, '.');

  if ($iDot === false) {
    $tag = $selector;
  } else {
    $class = substr(implode(' ', explode('.', substr($selector, $iDot))), 1);

    if ($iDot > 0) {
      $tag = substr($selector, 0, $iDot);
    }
  }

  if (!empty($class)) {
    if (array_key_exists('class', $attrs)) {
      $attrs['class'] = $class . ' ' . $attrs['class'];
    } else {
      $attrs['class'] = $class;
    }
  }

  return [
    'attrs' => $attrs,
    'tag' => $tag,
  ];
}

function t($selector, $attrs = null, $children = null) {
  if ($children === null && $attrs !== null && (
    is_string($attrs) || isSequential($attrs)
  )) {
    $children = $attrs;
    $attrs = null;
  }

  if ($attrs === null) {
    $attrs = [];
  }

  if ($children === null) {
    $children = [];
  }

  $selectorParsingResult = parseSelector($selector, $attrs);
  $attrs = $selectorParsingResult['attrs'];
  $tag = $selectorParsingResult['tag'];

  return [
    'attrs' => $attrs,
    'children' => $children,
    'tag' => $tag,
  ];
}

function stringifyAttrs($attrs) {
  $result = '';

  foreach ($attrs as $key => $value) {
    if ($value === false) {
      continue;
    }

    $result .= (
      ' ' .
      $key .
      ($value === true ? '' : ('="' . $value . '"'))
    );
  }

  return $result;
}

function stringify($node) {
  if (is_string($node)) {
    return $node;
  }

  if (is_array($node) && isSequential($node)) {
    $nodes = $node;
    return implode('', array_map(__NAMESPACE__ . '\stringify', $nodes));
  }

  $attrs = '';

  if (!empty($node['attrs'])) {
    $attrs = stringifyAttrs($node['attrs']);
  }

  $tag = $node['tag'];

  if ($tag === 'br') {
    return '<' . $tag . $attrs . '/>';
  }

  $children = '';

  if (!empty($node['children'])) {
    if (is_string($node['children'])) {
      $children = $node['children'];
    } else {
      $children = implode('', array_map(__NAMESPACE__ . '\stringify', $node['children']));
    }
  }

  return (
    '<' . $tag . $attrs . '>' .
    $children .
    '</' . $tag . '>'
  );
}
