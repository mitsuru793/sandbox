import $ from 'jQuery';
$('#user-form').on('submit', function (event) {
  event.preventDefault()
  const form = $(this)
  const serialize = form.serializeArray()
  const data = serializeArrayToObj(serialize, 'name', 'value')

  let invalidList = []
  if (data.name < 5) {
    invalidList.push('名前は5文字以上で入力してください。')
  }
  if (data.age < 20) {
    invalidList.push('20歳以上が対象です。')
  }
  alert(invalidList.join("\n"))
})

/**
 * プロパティkeyの値をkey, プロパティvalueをvalueとしたオブジェクトを生成
 *
 * [{'name': 'name', 'value': 'yamada'}, {'name': 'age', 'value': 20}]
 * を{'name': 'yamada', 'age': 20}に変換。
 */
function serializeArrayToObj(row, key, val) {
  const data = {}
  for (let i in row) {
    data[row[i][key]] = row[i][val]
  }
  return data
}
