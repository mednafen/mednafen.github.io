#!/bin/bash

wget -nv -O lib.js http://forum.fobby.net/lib.js >/dev/null && \
php index.php > index.html && \
cd releases && php index.php > index.html && cd .. && \
cd irc && php index.php > index.html && cd .. && \
cd links && php index.php > index.html && cd .. && \
git add --all && \
git status
