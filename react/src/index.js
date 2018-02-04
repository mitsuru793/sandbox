import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import registerServiceWorker from './registerServiceWorker';

import Timer from './2018-02-04_enable_start_button_of_timer_to_toggle.js';

ReactDOM.render(<Timer />, document.getElementById("root"));
registerServiceWorker();
