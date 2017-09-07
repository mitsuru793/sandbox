/*
awaitの戻り値はresolve, rejectに渡した引数。
*/
const assert = require('assert');

async function run() {
  let res = await makeResolve()
  assert('Success' === res)

  res = await makeReject()
  assert('Reject' === res)

  res = await makeReturn()
  assert(undefined === res)
}

function makeResolve() {
  return new Promise((resolve, reject) => {
    resolve('Success')
  })
}

function makeReject() {
  return new Promise((resolve, reject) => {
    resolve('Reject')
  })
}

function makeReturn() {
  return new Promise((resolve, reject) => {
    return 'Return'
  })
}
run()
