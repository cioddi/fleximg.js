sudo apt-get update > /dev/null
sudo apt-get install -y --force-yes apache2 libapache2-mod-php5 php5-curl php5-intl php5-curl php5-gd php5-idn php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-ming php5-ps php5-pspell php5-recode php5-snmp php5-sqlite php5-tidy php5-xmlrpc php5-xsl

sudo a2enmod rewrite
chmod 777 /home/travis/build/cioddi/fleximg.js/img/fleximg_scale

sudo sed -i -e "s,/var/www,/home/travis/build/cioddi/fleximg.js,g" /etc/apache2/sites-available/default
sudo /etc/init.d/apache2 restart

serverUrl='http://127.0.0.1:4444'
serverFile=selenium-server-standalone-2.35.0.jar
firefoxUrl=http://ftp.mozilla.org/pub/mozilla.org/firefox/releases/21.0/linux-x86_64/en-US/firefox-21.0.tar.bz2
firefoxFile=firefox.tar.bz2
phpVersion=`php -v`


pear channel-discover pear.phpunit.de
pear install phpunit/PHP_Invoker
pear install phpunit/DbUnit
pear install phpunit/PHPUnit_Selenium
pear install phpunit/PHPUnit_Story

echo "Downloading Firefox"
wget $firefoxUrl -O $firefoxFile
tar xvjf $firefoxFile

echo "Starting xvfb"
echo "Starting Selenium"
if [ ! -f $serverFile ]; then
    wget http://selenium.googlecode.com/files/$serverFile
fi
sudo xvfb-run java -jar $serverFile > /tmp/selenium.log &

wget --retry-connrefused --tries=60 --waitretry=1 --output-file=/dev/null $serverUrl/wd/hub/status -O /dev/null
if [ ! $? -eq 0 ]; then
    echo "Selenium Server not started"
else
    echo "Finished setup"
fi


npm install -g bower
bower install

ls -la ./