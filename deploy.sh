#!/usr/bin/env sh

# abort on errors

git init
git add -A
git commit -m 'deploy'

# if you are deploying to https://<USERNAME>.github.io/<REPO>
git push -f https://github.com/jesuscuri13/biblioteca.git master