import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import registerServiceWorker from './registerServiceWorker';

import Search from './2018-02-04_create_incremental_search.js';

ReactDOM.render(<Search />, document.getElementById("root"));
registerServiceWorker();
