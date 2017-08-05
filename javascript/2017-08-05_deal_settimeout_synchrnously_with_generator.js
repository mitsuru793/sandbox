/*
generatorでsetTimeoutを同期的に処理する。

参考: [generatorとJavaScriptの非同期処理 \- Qiita](http://qiita.com/hitsujiwool/items/316f3e8a41fb7dc3a119)
*/

function run1()
{
  let functions = [
    () => {
      console.log('Hello')
    },
    () => {
      setTimeout(() => {
        console.log('World')
      }, 1000)
    },
    () => {
      console.log('Finish')
    },
  ]
  let generator = (function *() {
    yield functions[0]();
    yield functions[1]();
    yield functions[2]();
  })();
  // nextを読んだ時点でyieldが実行されてしまう。
  // 待つにはsetTimeoutの中でnextを呼ばないといけない
  // つまり再開したいところでnextを呼ぶ。
  generator.next();
  generator.next();
  generator.next();
}

function run2()
{
  // このスコープからネストしたところまで、1つのgenerator関数を共有している。
  // そのためnextを呼べば全体を同期させることが可能。
  let functions = [
    (gen) => {
      console.log('Hello')
      // TypeError: Generator is already runningになる。
      // この関数が終わってyieldの部分に戻るまではrunningのため
      // gen.next()

      // タイマーに登録して、関数を終了させてyieldに戻ればgeneratorが止まる。
      setTimeout(() => gen.next(), 0)
    },
    (gen) => {
      setTimeout(() => {
        console.log('World')
        gen.next()
      }, 1000)
    },
    (gen) => {
      console.log('Finish')
    },
  ]
  let generator = (function *() {
    // ここで既にgeneratorには定義済みのgenerator関数がある。
    yield functions[0](generator);
    yield functions[1](generator);
    yield functions[2](generator);
  })();
  generator.next();
}

function run3() {
  // 好きなタイミングでnextを呼び出せば、次の関数を発火できる。
  let functions = [
    (next) => {
      console.log('Hello')
      next() // gen.next()呼ぶ
      // nextを呼んでもこの関数は実行される。
      // next内のsetTimeoutでタイマーに登録しているから。
      console.log('Hello end')
    },
    (next) => {
      setTimeout(() => {
        console.log('World')
        next()
      }, 1000)
    },
    (next) => {
      setTimeout(() => {
        console.log('!')
        next()
      }, 500)
    },
    (next) => {
      console.log('Finish')
    },
  ]

  function runnable(generator) {
    g = generator((val) => {
      // setTimeoutがないところでgenerator runningになるのを防ぐ。
      setTimeout(() => g.next(val), 0)
    })
    g.next();
  }
  runnable(function *(next) {
    yield functions[0](next)
    yield functions[1](next)
    yield functions[2](next)
    yield functions[3](next)
  });
}

function run4() {
  let functions = [
    (next) => {
      console.log('Hello')
      next()
      console.log('Hello end')
    },
    (next) => {
      setTimeout(() => {
        console.log('World')
        next()
      }, 1000)
    },
    (next) => {
      setTimeout(() => {
        console.log('!')
        next()
      }, 500)
    },
    (next) => {
      console.log('Finish')
    },
  ]

  function naiveCo(generator) {
    const g = generator()
    function next(data) {
      let result = g.next(data)
      if (result.done) return

      // yieldで渡された関数を実行。
      result.value((data) => {
        next(data)
      })
    }
    next()
  }

  naiveCo(function *() {
    // 関数を実行せずに渡す
    yield functions[0]
    yield functions[1]
    yield functions[2]
    yield functions[3]
  });
}
run4()
