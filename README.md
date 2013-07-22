#fleximg.js
Responsive Image solution - Automatically scales image media files to fit the desired display dimensions

##Installation
###Requirements
* mod_rewrite
* PHP
* Imagemagick
* jquery (install using "$ bower install")
* hammer.js (to detect pinch zoom events "$ bower install")

1. Make sure your apache webserver with PHP, mod_rewrite and imagemagick is up an running
2. Place the contents of this git project to your webroot and install requirements using ```$ bower install```
3. If you already have a .htaccess file put the following lines in 
```
<IfModule mod_rewrite.c>
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule img/scale/. /scale.php [L]

</IfModule>
```
4. Open demo.php to see if it works. You should see an image with cows in three different sizes.
5. To insert into your existing projects change the src attribute key in your img tags to data-src and load the following scripts
```
	<script src="/components/jquery/jquery.js"></script>
	<script src="/components/hammerjs/dist/jquery.hammer.js"></script>
	<script src="/scale.js"></script>
```


##How it works
1. Set the src of img tags to the data-src attribute and make sure to create style definition which affect the image dimension.
2. After the page loads scale.js will be executed and check all img tags for data-src attributes. If found it will set the src of the img to /img/scale/{IMG_WIDTH}/{IMG_HEIGHT}/{IMG_FILEPATH}.
3. If that file exists it will be delivered by the apache. If the is no file the request will be passed to  scale.php which will scale the image to the requested dimensions, save it to the desired path and redirect to it again.

##copyright
image - img/test.jpg (2013 Loren Kerns http://www.flickr.com/photos/lorenkerns/9262656978/)