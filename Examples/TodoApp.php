<?php
namespace Temple\Examples\TodoApp;

require_once(dirname(__FILE__) . '/../Temple.php');
use function Temple\stringify;
use function Temple\t;

function State() {
  return [
    'todos' => [
      [
        'done' => true,
        'id' => 0,
        'text' => 'Wake up',
      ],
      [
        'done' => false,
        'id' => 1,
        'text' => 'Drink coffee',
      ],
      [
        'done' => true,
        'id' => 2,
        'text' => 'Take shower',
      ],
    ],
  ];
}

function TodoListEntry($todo) {
  return (
    t('.todo-list-entry', [
      t('label.todo-list-entry-inner', [
        t('input.todo-list-entry-done', [
          'checked' => $todo['done'],
          'type' => 'checkbox'
        ]),
        ' ',
        t('span.todo-list-entry', $todo['text']),
      ]),
    ])
  );
}

function TodoList($state) {
  return t('.todo-list', array_map(__NAMESPACE__ . '\TodoListEntry', $state['todos']));
}

function TodoForm($state) {
  return (
    t('form.todo-form', [
      t('input.todo-form-control', [
        'placeholder' => 'Create a todo',
        'title' => 'Todo text',
        'type' => 'text',
      ]),
      t('button', [ 'type' => 'submit' ], 'Submit'),
    ])
  );
}

function TodoApp($state) {
  return (
    t('.todo-app', [
      TodoForm($state),
      TodoList($state),
    ])
  );
}
