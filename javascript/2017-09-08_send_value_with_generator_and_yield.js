/*
generatorとyieldで値を送信する

yieldに渡した値は外側に、generatorFunc.next()に渡すと内側に値が届く。
*/
const assert = require('assert');

function run() {
  const gen = genFunc()

  res = gen.next('out 0')
  assert.deepStrictEqual(res, {value: 'in 1', done: false})

  res = gen.next('out 1')
  assert.deepStrictEqual(res, {value: 'in 2', done: false})

  res = gen.next('out 2')
  assert.deepStrictEqual(res, {value: 'in 3', done: false})

  res = gen.next('out 3')
  assert.deepStrictEqual(res, {value: 'finish', done: true})

  res = gen.next('out 4')
  assert.deepStrictEqual(res, {value: undefined, done: true})
}

function* genFunc() {
  let res

  res = yield 'in 1'
  assert.strictEqual(res, 'out 1')

  res = yield 'in 2'
  assert.strictEqual(res, 'out 2')

  res = yield 'in 3'
  assert.strictEqual(res, 'out 3')

  return 'finish'
}

run()
