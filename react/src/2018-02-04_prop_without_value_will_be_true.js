/*
propに値なしで指定すると、値はtrueになる。
*/
// @flow
import React from 'react';

function Items() {
  return (
    <ul className='items'>
      <Item value='normal'/>
      <Item value='warning' warning/>
      <Item value='error' error/>
    </ul>
  );
}

function Item(props: {
  value: string,
  warning?: bool,
  error?: bool,
}) {
  console.log(props);
  const classNames = [
    'item',
    props.warning ? 'warning' : '',
    props.error ? 'error' : '',
  ];
  return (
    <li className={classNames.join(' ').trim()}>
      {props.value}
    </li>
  );
}

const style = document.createElement('style');
style.textContent = `
.warning {
  background-color: yellow;
}
.error {
  background-color: red;
}
`;
document.getElementsByTagName('body')[0].appendChild(style);

export default Items;
