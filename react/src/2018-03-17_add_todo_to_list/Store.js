// @flow

class Store {
  static save(namespace: string, data: mixed): void {
    localStorage.setItem(namespace, JSON.stringify(data));
  }

  static get(namespace: string): mixed {
    const store = localStorage.getItem(namespace);
    return (store && JSON.parse(store));
  }
}

export default Store;
