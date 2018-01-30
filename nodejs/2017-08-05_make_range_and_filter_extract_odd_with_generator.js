/*
generatorでrangeを作り、偶数を抽出する。
*/
function* filterOdd(nums)
{
  for (num of nums) {
    if (num % 2 === 0) {
      yield num
    }
  }
}

function* range(min, max)
{
  for (let i = min; i < max; i++) {
    yield i
  }
}

for (n of filterOdd(range(5, 10))) {
  console.log(n)
}
