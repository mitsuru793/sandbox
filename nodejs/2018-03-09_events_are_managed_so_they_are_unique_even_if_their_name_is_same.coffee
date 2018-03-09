###
eventはインスタンスごとで管理されるので、イベント名が重複しても別になる。
###
EventEmitter = require 'events'

emitter1 = new EventEmitter
emitter2 = new EventEmitter

emitter1.on 'same', =>
  console.log 'from 1'
emitter2.on 'same', =>
  console.log 'from 2'

emitter1.emit 'same'
console.log '---'
emitter2.emit 'same'
