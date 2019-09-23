SRC_MD_FILES != find source -name '*.md'
DST_HTML_FILES := $(SRC_MD_FILES:source/%.md=%.html)

PANDOC != command -v pandoc 2> /dev/null

all: $(DST_HTML_FILES)

%.html: source/%.md
	$(PANDOC) \
		--template wiki.tmpl \
		--lua-filter header-permalinks.lua \
		--title-prefix "tilde.club wiki" \
		--standalone \
		--table-of-contents \
		--output $@ \
		$<

clean:
	rm *.html

.PHONY: clean

