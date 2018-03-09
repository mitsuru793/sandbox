###
eventのエラー処理をする

errorというイベント名は特別。未登録のイベントという理由で例外は発生しない。
###
EventEmitter = require 'events'

emitter = new EventEmitter

emitter.emit 'missing'

try
  emitter.emit 'error'
catch e
  console.log e

console.log '-----'

emitter.on 'error', (err) =>
  console.error 'occur error'
emitter.emit 'error'
