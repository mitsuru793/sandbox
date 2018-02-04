import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import registerServiceWorker from './registerServiceWorker';

import Items from './2018-02-04_prop_without_value_will_be_true.js';

ReactDOM.render(<Items />, document.getElementById("root"));
registerServiceWorker();
