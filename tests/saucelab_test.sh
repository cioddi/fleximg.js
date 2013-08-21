CONNECT_URL="http://saucelabs.com/downloads/Sauce-Connect-latest.zip"
CONNECT_DIR="sauce-connect-$RANDOM"
CONNECT_DOWNLOAD="Sauce_Connect.zip"
READY_FILE="connect-ready-$RANDOM"

sudo apt-get update
sudo apt-get install php5-curl php5-xdebug

curl -s https://raw.github.com/jlipps/sausage-bun/master/givememysausage.php | SAUCE_USERNAME=$SAUCE_USERNAME SAUCE_ACCESS_KEY=$SAUCE_ACCESS_KEY php

vendor/bin/sauce_config $SAUCE_USERNAME $SAUCE_ACCESS_KEY

vendor/bin/sauce_connect
# Get Connect and start it
# mkdir -p $CONNECT_DIR
# cd $CONNECT_DIR
# curl $CONNECT_URL > $CONNECT_DOWNLOAD
# unzip $CONNECT_DOWNLOAD
# rm $CONNECT_DOWNLOAD
# java -jar Sauce-Connect.jar $SAUCE_USERNAME $SAUCE_ACCESS_KEY -P 2000 --readyfile $READY_FILE --tunnel-identifier $TRAVIS_JOB_NUMBER &

# Wait for Connect to be ready before exiting
# while [ ! -f $READY_FILE ]; do
#   sleep .5
# done


# cd ..



pwd
ls -la
vendor/bin/phpunit tests/saucelabs/simpleDemoTestIphone.php