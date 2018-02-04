import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import registerServiceWorker from './registerServiceWorker';

import Timer from './2018-02-04_make_timer_has_buttons_of_start_stop_reset.js';

ReactDOM.render(<Timer />, document.getElementById("root"));
registerServiceWorker();
