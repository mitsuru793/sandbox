// @flow

import uuidv1 from 'uuid/v1';
import Store from './Store';

/**
 * subscribeで配列valuesの値が変更された時に実行される、コールバックを登録する。
 */
class TodoList {
  namespace: string;
  values: Array<{
    id: string,
    title: string,
    completed: bool,
  }>;
  onChanges: Function[];

  constructor(namespace: string) {
    this.namespace = namespace;
    this.values = [];
    this.onChanges = [];
  }

  subscribe(onChange: Function) {
    this.onChanges.push(onChange);
  }

  inform() {
    Store.save(this.namespace, this.values);
    this.onChanges.forEach((cb) => cb());
  }

  add(title: string) {
    this.values.push({
      id: uuidv1(),
      title: title,
      completed: false,
    });
    this.inform();
  }
}

export default TodoList;
