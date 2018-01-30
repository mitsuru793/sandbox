/*
Promiseでインクリメントする。
*/
function incrementUntil5(number) {
  return new Promise((resolve, reject) => {
    if (number < 5) {
      resolve(number + 1)
    } else {
      reject(`${number} is max`)
    }
  })
}

incrementUntil5(0).then((num) => {
  console.log(num) // 1
  return incrementUntil5(num)
}).then((num) => {
  console.log(num) // 2
  return incrementUntil5(num)
}).then((num) => {
  console.log(num) // 3
  return incrementUntil5(num)
}).then((num) => {
  console.log(num) // 4
  return incrementUntil5(num)
}).then((num) => {
  console.log(num) // 5
  return incrementUntil5(num)
}).then((num) => {
  console.log(num) // 6 実行されない
  console.log('not execute')
  return incrementUntil5(num)
}).catch((error) => {
  console.log(error)
})

function incrementUntil(max) {
  return (number) => {
    return new Promise((resolve, reject) => {
      if (number < max) {
        resolve(number + 1)
      } else {
        reject(`${number} is max`)
      }
    })
  }
}

// タイマーに登録しないと、上記のpromiseと並列に実行されてしまう。
setTimeout(() => {
  incrementUntil3 = incrementUntil(3)
  incrementUntil3(0).then((num) => {
    console.log(num) // 1
    return incrementUntil3(num)
  }).then((num) => {
    console.log(num) // 2
    return incrementUntil3(num)
  }).then((num) => {
    console.log(num) // 3
    return incrementUntil3(num)
  }).then((num) => {
    console.log(num) // 4
    return incrementUntil3(num)
  }).then((num) => {
    console.log(num) // 5 実行されない
    console.log('not execute')
    return incrementUntil3(num)
  }).catch((error) => {
    console.log(error)
  })
}, 0)
