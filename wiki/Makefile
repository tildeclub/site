SRC_MD_FILES != find source -name '*.md'
DST_HTML_FILES := $(SRC_MD_FILES:source/%.md=%.html)
DST_TXT_FILES := $(SRC_MD_FILES:source/%.md=%.txt)
PANDOC != command -v pandoc 2> /dev/null
PHP != command -v php 2> /dev/null

all: dep-pandoc $(DST_HTML_FILES) $(DST_TXT_FILES) index

index: dep-php index.html
%.html: %.php
	php $< > $@

%.html: source/%.md wiki.tmpl custom.theme
	$(info building $@)
	@$(PANDOC) \
		--from markdown+backtick_code_blocks \
		--include-before-body=../nav.html \
		--template wiki.tmpl \
		--lua-filter header-permalinks.lua \
		--highlight-style=custom.theme \
		--title-prefix "tilde.club wiki" \
		--variable toc-title:"table of contents" \
		--standalone \
		--table-of-contents \
		--output $@ \
		$<

%.txt: source/%.md link_footnote.lua
	$(info building $@)
	@$(PANDOC) \
		--from markdown+backtick_code_blocks \
		--to plain \
		--lua-filter ./link_footnote.lua \
		--standalone \
		--output $@ \
		$<

clean:
	$(info removing generated files)
	-rm *.html *.txt

dep-pandoc::
ifndef PANDOC
	$(error missing dependency 'pandoc'. please install and try again)
endif

dep-php::
ifndef PHP
	$(error missing dependency 'php'. please install and try again)
endif

.PHONY: clean dep-pandoc

