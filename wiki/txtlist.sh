#!/bin/sh

for txt in ./*.txt; do
  printf "0%s\t%s\ttilde.club\t70\n" "$(head -n1 $txt)" "/wiki/${txt#"./"}"
done

