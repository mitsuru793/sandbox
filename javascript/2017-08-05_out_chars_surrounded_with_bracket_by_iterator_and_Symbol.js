/*
iteratorとSymbolで文字列の各文字をブラケットで囲んで出力

参考: [JavaScript の イテレータ を極める！ \- Qiita](http://qiita.com/kura07/items/cf168a7ea20e8c2554c6)
*/

function makeIterator() {
  const str = 'hello'
  let i = 0
  const iterator = {}
  iterator.next = function(){
    if (i < str.length) {
      iteratorResult = { value: `[${str[i]}]`, done: false }
    } else {
      iteratorResult = { value: undefined, done: true }
    }
    i++
    return iteratorResult
  }
  return iterator
}

// doneは使っていない。
function run1() {
  let iterator = makeIterator()
  while ((iteratorResult = iterator.next()).value) {
    console.log(iteratorResult.value)
  }
}

// doneを使う
function run2() {
  let iterator = makeIterator()
  while (true) {
    iteratorResult = iterator.next()
    if (iteratorResult.done) break
    console.log(iteratorResult.value)
  }
}

// Symbolを使えばオブジェクトにiteratorを実装できる
function run3() {
  const obj = {}
  obj[Symbol.iterator] = () => {
    return makeIterator()
  }

  // 戻り値のvalueプロパティが取得される。
  // ループするかはdoneプロパティで判断
  for (c of obj) {
    console.log(c)
  }
}

run3()
