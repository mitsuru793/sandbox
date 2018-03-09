###
イベントの処理を一度だけにする
###
EventEmitter = require 'events'

emitter = new EventEmitter

m = 0
emitter.once 'event', =>
  console.log ++m

emitter.emit 'event'
emitter.emit 'event'
