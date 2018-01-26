{-
数字のリストの要素を、文字列の奇数、偶数に置き換える。
-}

toOddEven xs = [if odd x then "odd" else "even" | x <- xs]
main = putStrLn(show(toOddEven [1..5]))
