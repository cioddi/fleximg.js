READY_FILE="connect-ready-$RANDOM"

sudo apt-get update
sudo apt-get install php5-xdebug

curl -s https://raw.github.com/jlipps/sausage-bun/master/givememysausage.php | SAUCE_USERNAME=$SAUCE_USERNAME SAUCE_ACCESS_KEY=$SAUCE_ACCESS_KEY php
php composer.phar require "sauce/connect:>=3.0"

vendor/bin/sauce_config $SAUCE_USERNAME $SAUCE_ACCESS_KEY

vendor/bin/sauce_connect --readyfile $READY_FILE > vendor/sauceconnectlog &

# Wait for Connect to be ready before exiting
while [ ! -f $READY_FILE ]; do
  sleep .5
done