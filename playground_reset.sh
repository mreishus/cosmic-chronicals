#!/bin/bash

cd wp-content || exit
npx @wp-now/wp-now start --reset --blueprint=blueprint-reset.json
cd ..
