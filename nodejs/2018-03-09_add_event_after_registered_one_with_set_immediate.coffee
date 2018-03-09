###
登録したeventの最後に処理を登録する場合はsetImmediateを使う
###
EventEmitter = require('events')

class MyEmitter extends EventEmitter

emitter = new MyEmitter()

emitter.on 'hello', =>
  console.log 'hello 1'
  console.log 'hello 2'
emitter.on 'hello', => console.log('hello 3')
emitter.emit 'hello'

# hello 1
# hello 2
# hello 3

emitter.on 'world',  =>
  console.log 'world 1'
  setImmediate => console.log 'world @1'
emitter.on 'world', =>
  console.log('world 2')
  setImmediate => console.log 'world @2'
emitter.on 'world', => console.log('world 3')
emitter.emit 'world'

# world 1
# world 2
# world 3
# world @1
# world @2
