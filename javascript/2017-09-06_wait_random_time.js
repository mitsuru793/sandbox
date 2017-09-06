/*
ランダムの時間、待機する。
*/
async function run() {
  const [min, max] = [0, 2000]
  for (let i = 0; i < 5; i++) {
    time = Math.random() * (max - min) + min
    console.log(`${i} ${time}`)
    await wait(time)
  }
}

function wait(ms) {
  return new Promise(resolve => setTimeout(resolve, ms))
}

run()
