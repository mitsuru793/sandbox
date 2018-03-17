// @flow

import React from 'react';
import FormItems from './FormItems';
import TodoList from './TodoList';

type Props = {
  todoList: TodoList,
}

type State = {
  newTodo: string,
}

class TodoForm extends React.Component<Props, State> {
  todoList: TodoList;

  constructor(props: Props) {
    super(props);
    this.state = {
      newTodo: '',
    };
  }

  handleTextChange(event: SyntheticInputEvent<HTMLInputElement>) {
    this.setState({newTodo: event.target.value});
  }

  handleSubmit(event: SyntheticInputEvent<HTMLInputElement>) {
    event.preventDefault();
    if (!this.state.newTodo) {
      alert('Todo is empty.');
      return;
    }
    this.props.todoList.add(this.state.newTodo);
    this.setState({newTodo: ''});
  }

  render() {
    return (
      <div>
        <form onSubmit={(e) => this.handleSubmit(e)}>
          TODO:
          <input
            type='text'
            value={this.state.newTodo}
            onChange={(e) => this.handleTextChange(e)}/>
          <input
            type='submit'
            value='Add'/>
        </form>
        <FormItems todoList={this.props.todoList}/>
      </div>
    );
  }
}

export default TodoForm;
