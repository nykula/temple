<?php
namespace Temple\Examples\TodoApp;

require_once(dirname(__FILE__) . '/../Temple.php');
use Temple\Temple;

function t($selector, $attrs = null, $children = null) {
  return Temple::t($selector, $attrs, $children);
}

class TodoApp {
  public static function State() {
    return [
      'todos' => [
        [
          'done' => true,
          'text' => 'Wake up',
        ],
        [
          'done' => false,
          'text' => 'Drink coffee',
        ],
        [
          'done' => true,
          'text' => 'Take shower',
        ],
      ],
    ];
  }

  public static function TodoListEntry($todo) {
    return (
      t('.todo-list-entry', [
        t('label.todo-list-entry-inner', [
          t('input.todo-list-entry-done', [
            'checked' => $todo['done'],
            'type' => 'checkbox'
          ]),
          ' ',
          t('span.todo-list-entry-text', $todo['text']),
        ]),
      ])
    );
  }

  public static function TodoList($state) {
    return t('.todo-list', array_map(__NAMESPACE__ . '\TodoApp::TodoListEntry', $state['todos']));
  }

  public static function TodoForm() {
    return (
      t('form.todo-form', [
        t('input.todo-form-text', [
          'placeholder' => 'Create a todo',
          'title' => 'Todo text',
          'type' => 'text',
        ]),
        t('button', [ 'type' => 'submit' ], 'Submit'),
      ])
    );
  }

  public static function TodoApp($state) {
    return (
      t('.todo-app', [
        TodoApp::TodoForm(),
        TodoApp::TodoList($state),
      ])
    );
  }
}
