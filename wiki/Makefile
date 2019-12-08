SRC_MD_FILES != find source -name '*.md'
DST_HTML_FILES := $(SRC_MD_FILES:source/%.md=%.html)

PANDOC != command -v pandoc 2> /dev/null
PHP != command -v php 2> /dev/null

all: dep-pandoc $(DST_HTML_FILES)

index: dep-php index.html
%.html: %.php
	php $< > $@

%.html: source/%.md
	$(info building $@)
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
	$(info removing generated files)
	-rm $(DST_HTML_FILES)

dep-pandoc::
ifndef PANDOC
	$(error missing dependency 'pandoc'. please install and try again)
endif

dep-php::
ifndef PHP
	$(error missing dependency 'php'. please install and try again)
endif

.PHONY: clean dep-pandoc

