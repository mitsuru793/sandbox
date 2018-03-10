=begin
to_sとto_strの違い

to_strは文字列結合の時に呼び出される。
=end

require 'awesome_print'

class User
  attr_reader :name

  def initialize(name)
    @name = name
  end

  def to_s
    "name: #{@name} in to_s"
  end

  def to_str
    "name: #{@name} in to_str"
  end
end

user = User.new('mike')

puts user
puts "[#{user}]"
puts '[' + user + ']'
