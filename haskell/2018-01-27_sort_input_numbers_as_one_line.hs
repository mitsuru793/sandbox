{-
1行に入力された数字をソートする
-}

import Control.Applicative
import Data.List

main = do
  ns <- (map read . words) <$> getLine :: IO [Int]
  print $ sort ns
