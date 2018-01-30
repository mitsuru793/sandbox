/*
setTimeoutを配列で管理して、同期させてシーケンシャルに実行する。

前のsetTimeoutが実行された後に、次のsetTimeoutを実行する。
同時に全てをタイマーに登録させない。
*/
// すぐにどちらもキューに入り、カウントが走るので同時に出力される。
function run1() {
  setTimeout(() => {
    console.log('hello')
  }, 1000)

  setTimeout(() => {
    console.log('world')
  }, 1000)
}

// setTimeoutを入れ子にすれば、1個目が実行した時に2個目をキューに登録できる。
// 同期的にするsetTimeoutの数だけネストすることになる。
function run2() {
  setTimeout(() => {
    console.log('hello')
    setTimeout(() => {
      console.log('world')
    }, 1000)
  }, 1000)
}

// 配列で管理しようとしても、()が関数呼出しのためsetTimeoutの戻り値が配列の要素にある。
function run3() {
  queue = [
    setTimeout(() => {
      console.log('hello')
    }, 1000),
    setTimeout(() => {
      console.log('world')
    }, 1000),
  ]
  console.log(queue)
}

// 関数として渡すために無名関数でラップする。アロー関数も使える。
// しかし同時に実行されてしまう。
function run4() {
  queue = [
    function () {
      setTimeout(() => {
        console.log('hello')
      }, 1000)
    },
    () => {
      setTimeout(() => {
        console.log('world')
      }, 1000)
    },
  ]
  console.log(queue)
  queue[0]()
  queue[1]()
}

// setTimeoutに渡す引数を配列の要素として定義しておく。
// しかし、ネストは実現できていない。
function run5()
{
  queue = [
    [
      () => {
        console.log('hello')
      }, 1000
    ],
    [
      () => {
        console.log('world')
      }, 1000
    ],
  ]
  queue.forEach((funcData, i, ary) => {
    // 関数として渡すので[0]()と呼び出さない
    setTimeout(funcData[0], funcData[1])
  })
}

// タイミングはずらすことができるが、キューの登録は同時になっている。
// 前のが終わってから登録をしているわけではないため、
// callbackの処理が重いと終わる前に次のが実行されてしまう。
function run6()
{
  queue().reduce((totalTime, funcData, i, ary) => {
    setTimeout(funcData[0], totalTime)
    return totalTime + funcData[1]
  }, 0);
}

// 配列の末尾から前の要素でラップしていく
// キューの登録は同時ではなく、外側が終わる度に内側を登録していく。
function run7()
{
  queue = [
    [
      () => {
        console.log('hello')
      }, 1000
    ],
    [
      () => {
        console.log('world')
      }, 1000
    ],
  ]
  chain = queue.reverse().reduce((carry, funcData) => {
    return () => {
      setTimeout(() => {
        funcData[0]()
        carry()
      }, funcData[1])
    }
  }, () => {})
  chain()
}

// 無名関数のみをキューにした場合は、即時実行されるため同期できない。
// intervalの値を固定値にするなら、reduceの中で上記と同じようにsetTimeoutが使える。
function run8()
{
  queue = [
    () => {
      setTimeout(() => {
        console.log('hello')
      }, 1000)
    },
    () => {
      setTimeout(() => {
        console.log('world')
      }, 1000)
    }
  ]
  chain = queue.reverse().reduce((carry, func) => {
    return () => {
      func()
      carry()
    }
  }, () => {})
  chain()
}
run8()
