<?php
namespace Temple;

class Temple {
  private static function isSequential($array) {
    return array_keys($array) === range(0, count($array) - 1);
  }

  private static function parseSelector($selector, $attrs) {
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

  public static function t($selector, $attrs = null, $children = null) {
    if ($children === null && $attrs !== null && (
      is_string($attrs) || Temple::isSequential($attrs)
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

    $selectorParsingResult = Temple::parseSelector($selector, $attrs);
    $attrs = $selectorParsingResult['attrs'];
    $tag = $selectorParsingResult['tag'];

    return [
      'attrs' => $attrs,
      'children' => $children,
      'tag' => $tag,
      'type' => 'tag',
    ];
  }

  private static function stringifyAttrs($attrs) {
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

  public static function stringify($node) {
    if (is_string($node)) {
      return htmlspecialchars($node);
    }

    if (is_array($node) && Temple::isSequential($node)) {
      $nodes = $node;
      return implode('', array_map(__NAMESPACE__ . '\Temple::stringify', $nodes));
    }

    if ($node['type'] === 'text') {
      return $node['data'];
    }

    $attrs = '';

    if (!empty($node['attrs'])) {
      $attrs = Temple::stringifyAttrs($node['attrs']);
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
        $children = implode('', array_map(__NAMESPACE__ . '\Temple::stringify', $node['children']));
      }
    }

    return (
      '<' . $tag . $attrs . '>' .
      $children .
      '</' . $tag . '>'
    );
  }

  public static function trust($string) {
    return [
      'data' => $string,
      'type' => 'text',
    ];
  }
}
