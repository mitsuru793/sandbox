/*
1ファイルでサーバを立てて、fetchでレンスポンスを取得する。
*/
const http = require('http')
const fetch = require('node-fetch')

http.createServer((req, res) => {
  res.writeHead(200, {'Content-Type': 'text/plain'})
  res.end('Hello World')
}).listen(8000)
console.log('Server running at http://localhost:8000/')

// プロトコルhttp://は必須
fetch('http://localhost:8000')
  .then((res) => {
    // promiseが返る
    return res.text()
  })
  .then((body) => {
    console.log(body)
    process.exit()
  })
