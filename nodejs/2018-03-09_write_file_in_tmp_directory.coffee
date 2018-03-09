###
tmpディレクトリにファイルを書き込む

nodeはreadFileの戻り値ではなく、コールバックで読み込んだ内容を処理する。
###
os = require 'os'
fs = require 'fs'
path = require 'path'
assert = require 'assert'

tmpDir = os.tmpdir()
file = path.join(tmpDir, 'hoge')

fs.writeFile file, 'hello world1', =>
fs.readFile file, 'utf8', (err, data) => console.log data
