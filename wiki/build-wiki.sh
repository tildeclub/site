#!/bin/sh

for page in source/*.md; do
	pagename=$(basename $page ".md")
	pandoc --template pandoc-template.html -o "$pagename.html" "source/$pagename.md"
done

