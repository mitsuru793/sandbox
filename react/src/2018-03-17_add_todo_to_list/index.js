/*
todoをリストに追加する

thanks: http://todomvc.com/
*/
import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import registerServiceWorker from '../registerServiceWorker';

import TodoForm from 'TodoForm';
import TodoList from 'TodoList';

const todoList = new TodoList('sandbox');
function render() {
  ReactDOM.render(<TodoForm todoList={todoList}/>, document.getElementById('root'));
}
todoList.subscribe(render);
render();

registerServiceWorker();
