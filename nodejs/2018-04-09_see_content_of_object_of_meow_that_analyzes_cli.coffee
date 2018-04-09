###
cli解析のmeowのオブジェクトの中身を見る

+ flagは引数と位置を混ぜても大丈夫
+ 実行時の読み込んだpackage名とバージョンが分かる
###
meow = require('meow')

cli = meow """
  Usage
    $ say <messsage>

  Options
    --shout, -s  Include a exclamation mark
""",
flags:
  shout:
    type: 'boolean'
    alias: 's'

console.log(cli)

###
$ node mellow.js a b c -s
input: [ 'a', 'b', 'c' ],
flags: { shout: true, s: true },
pkg:
 { scripts: { webpack: 'webpack', serve: 'webpack-dev-server --inline' },
   dependencies:
    { express: '^4.15.3',
      jquery: '^3.2.1',
      meow: '^4.0.0',
      'node-fetch': '^1.7.1',
      webpack: '^3.4.1',
      'webpack-dev-server': '^2.6.1' },
   name: '',
   version: '',
   readme: 'ERROR: No README data found!',
   _id: '@' },
help: '\n  Usage\n    $ say <messsage>\n\n  Options\n    --shout, -s  Include a exclamation mark\n',
showHelp: [Function: showHelp],
showVersion: [Function: showVersion] }
###
