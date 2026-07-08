#!/usr/bin/env bash

set -e

SRC="$HOME/xukera/website/en"
DEST="/var/www/xukera.com/public_html"

echo "Deploying xukera.com..."

sudo mkdir -p "$DEST/assets/css"
sudo mkdir -p "$DEST/assets/js"
sudo mkdir -p "$DEST/assets/js/intro"
sudo mkdir -p "$DEST/assets/images"

sudo cp "$SRC/index.html" "$DEST/index.html"
sudo cp "$SRC/assets/css/style.css" "$DEST/assets/css/style.css"
sudo cp "$SRC/assets/js/graph.js" "$DEST/assets/js/graph.js"
sudo cp "$SRC/assets/js/intro.js" "$DEST/assets/js/intro.js"
sudo cp "$SRC/assets/js/intro/IntroDirector.js" "$DEST/assets/js/intro/IntroDirector.js"
sudo cp "$SRC/assets/images/xukera-logo.png" "$DEST/assets/images/xukera-logo.png"

sudo mkdir -p "$DEST/assets/js/graph"

sudo cp "$SRC/assets/js/graph/GraphNode.js" "$DEST/assets/js/graph/GraphNode.js"
sudo cp "$SRC/assets/js/graph/Pulse.js" "$DEST/assets/js/graph/Pulse.js"
sudo cp "$SRC/assets/js/graph/GraphEngine.js" "$DEST/assets/js/graph/GraphEngine.js"

echo "Done."
