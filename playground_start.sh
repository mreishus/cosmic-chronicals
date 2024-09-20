#!/bin/bash

cd wp-content || exit
npx @wp-now/wp-now start --blueprint=blueprint.json
cd ..