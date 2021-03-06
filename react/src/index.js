import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import registerServiceWorker from './registerServiceWorker';

// ReactDOM.render(<TodoForm />, document.getElementById("root"));
import TodoForm from './2018-03-17_add_todo_to_list/TodoForm';
import TodoList from './2018-03-17_add_todo_to_list/TodoList';

const todoList = new TodoList('sandbox');
function render() {
  ReactDOM.render(<TodoForm todoList={todoList}/>, document.getElementById('root'));
}
todoList.subscribe(render);
render();
registerServiceWorker();
