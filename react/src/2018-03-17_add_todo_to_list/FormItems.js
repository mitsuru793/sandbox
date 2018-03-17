// @flow

import React from 'react';
import TodoList from './TodoList';

function FormItems(props: { todoList: TodoList }) {
  return (
    <ul className='items'>
      {
        props.todoList.values.map((v) => {
          return (
            <li id={v.id}
                className='item'>
              {v.title}
            </li>
          )
        })
      }
    </ul>
  );
}

export default FormItems;
