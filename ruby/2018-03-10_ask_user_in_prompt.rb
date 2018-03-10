=begin
プロンプトでユーザーに尋ねる
=end

require 'readline'
require 'awesome_print'

def ask(prompt="", newline=false)
  prompt += "\n" if newline
  Readline.readline(prompt, true).squeeze(" ").strip
end

result = ask 'hello'
ap result
