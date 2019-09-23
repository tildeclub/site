#!/bin/sh

printf "removing previous html build artifacts"
rm *.html

for page in source/*.md; do
    pagename=$(basename $page ".md")
    printf "building %s wiki article\n" "$pagename"

    pandoc \
        --toc \
        --template wiki.tmpl \
        --lua-filter header-permalinks.lua \
        -T "tilde.club wiki | " \
        -o "$pagename.html" \
        "source/$pagename.md"
done

