/*
非同期とawaitを使った同期処理
*/

// 非同期で実行するので、待ち時間が少ないものが先に完了する。
function run() {
  wait(500).then((value) => {
    console.log(value)
  })

  wait(300).then((value) => {
    console.log(value)
  })

  wait(100).then((value) => {
    console.log(value)
  })
}
/*
start wait 500
start wait 300
start wait 100
setTimeout 100
done 100
setTimeout 300
done 300
setTimeout 500
done 500
*/

// setTimeoutが終わってから、次のwaitが走るがthenがネストする。
function run2() {
  wait(500).then((value) => {
    console.log(value)
  }).then(() => {
    wait(300).then((value) => {
      console.log(value)
    }).then(() => {
      wait(100).then((value) => {
        console.log(value)
      })
    })
  })
}
/*
start wait 500
setTimeout 500
done 500
start wait 300
setTimeout 300
done 300
start wait 100
setTimeout 100
done 100
*/

// awaitを使うと見やすくなる。
async function run3() {
  let res
  res = await wait(500)
  console.log(res)
  // awitで待機しないとresolveされていないので、
  // Promise { <pending> }が出力される。

  res = await wait(300)
  console.log(res)

  res = await wait(100)
  console.log(res)
}
/*
start wait 500
setTimeout 500
done 500
start wait 300
setTimeout 300
done 300
start wait 100
setTimeout 100
done 100
*/

function wait(ms) {
  console.log(`start wait ${ms}`);
  return new Promise(resolve => setTimeout(() => {
    console.log(`setTimeout ${ms}`);
    resolve(`done ${ms}`)
  }, ms));
}

// run()
// run2()
run3()
