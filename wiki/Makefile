SRC_MD_FILES != find source -name '*.md'
DST_HTML_FILES := $(SRC_MD_FILES:source/%.md=%.html)

PANDOC != command -v pandoc 2> /dev/null

all: $(DST_HTML_FILES)

%.html: source/%.md
	@echo "building $@"
	@$(PANDOC) \
		--template wiki.tmpl \
		--lua-filter header-permalinks.lua \
		--title-prefix "tilde.club wiki" \
		--variable toc-title:"table of contents" \
		--standalone \
		--table-of-contents \
		--output $@ \
		$<

clean:
	@echo "removing generated files"
	@rm $(DST_HTML_FILES)

.PHONY: clean

