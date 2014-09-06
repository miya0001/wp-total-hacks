# パッケージ名
PACKAGE = wp-total-hacks
# パッケージのタイプ。plugin または theme
PROJECT = plugin
# 本家 (url) より入手してインストールしておいたもの
MAKEPOT = $(HOME)/wordpress-i18n/makepot.php


PHP = php
MSGMERGE = msgmerge
MSGFMT = msgfmt

srcdir = ..
langdir = .

GENPOT=$(PHP) $(MAKEPOT) wp-$(PROJECT) $(srcdir)

POT=$(PACKAGE).pot
ALL_LINGUAS =
PO_LINGUAS=$(shell if test -r $(langdir)/LINGUAS; then grep -v "^\#" $(langdir)/LINGUAS; else echo "$(ALL_LINGUAS)"; fi)

ifeq ($(PROJECT),plugin)
	PO_PREFIX=$(PACKAGE)-
endif
POFILES=$(shell LINGUAS="$(PO_LINGUAS)"; for lang in $$LINGUAS; do printf "$(PO_PREFIX)$$lang.po "; done)
MOFILES=$(POFILES:%.po=%.mo)

.SUFFIXES:
.SUFFIXES: .po .mo
.po.mo:
	$(MSGFMT) -o $@ $<

mo: $(MOFILES)

po: $(POFILES)

$(POFILES): $(POT)
	tmpdir=`pwd`; \
	  echo "$*:"; \
	  result="`$(MSGMERGE) -o $$tmpdir/$*.new.po $(langdir)/$@ $(POT)`"; \
	  if $$result; then \
	    if cmp $(langdir)/$@ $$tmpdir/$*.new.po >/dev/null 2>&1; then \
	      rm -f $$tmpdir/$*.new.po; \
	    else \
	      if mv -f $$tmpdir/$*.new.po $@; then \
	        :; \
	      else \
	        echo "msgmerge for $@ failed: cannot move $$tmpdir/$*.new.po to @" 1>&2; \
	        rm -f $$tmpdir/$*.new.po; \
	        exit 1; \
	      fi; \
	    fi; \
	  else \
	    echo "msgmerge for $@ failed!"; \
	    rm -f $$tmpdir/$*.new.po; \
	  fi; \

pot:
	$(GENPOT) $(POT)
