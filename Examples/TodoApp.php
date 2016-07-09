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

function TodoListEntry($todo) {
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

function TodoList($state) {
  return t('.todo-list', array_map(__NAMESPACE__ . '\TodoListEntry', $state['todos']));
}

function TodoForm() {
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

function TodoApp($state) {
  return (
    t('.todo-app', [
      TodoForm(),
      TodoList($state),
    ])
  );
}
