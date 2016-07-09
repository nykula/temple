(function () {
  var isNoticeAdded = false;

  var appElem = document.getElementById('app');
  var todoForm = document.querySelector('.todo-form');
  var todoFormText = document.querySelector('.todo-form-text');

  todoForm.addEventListener('submit', handleSubmit);
  todoFormText.focus();

  function addNotice() {
    if (isNoticeAdded) {
      return;
    }

    var noticeElem = document.createElement('div');
    noticeElem.classList.add('todo-notice');
    noticeElem.innerHTML = 'This app just adds elements to the document.<br>You could use window.__INITIAL_STATE__ to hydrate your frontend.';

    appElem.appendChild(noticeElem);
    isNoticeAdded = true;
  }

  function addTodo(text) {
    var todoListElem = document.querySelector('.todo-list');
    var todoElem = todoListElem.querySelector('.todo-list-entry').cloneNode(true);

    var todoDoneElem = todoElem.querySelector('.todo-list-entry-done');
    var todoTextElem = todoElem.querySelector('.todo-list-entry-text');

    todoDoneElem.checked = false;
    todoTextElem.innerText = text;

    todoListElem.appendChild(todoElem);
  }

  function handleSubmit(ev) {
    ev.preventDefault();
    var text = todoFormText.value.trim();

    if (text.length === 0) {
      return;
    }

    todoFormText.value = '';
    addTodo(text);
    addNotice();
  }
})();
