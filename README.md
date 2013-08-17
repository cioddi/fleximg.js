#fleximg.js

Responsive image solution - Automatically scales image media files to fit the desired display dimensions

##Requirements
* mod_rewrite
* PHP
* Imagemagick
* jquery (install using "$ bower install")
* hammer.js (to detect pinch zoom events "$ bower install")

##Installation
1. Make sure your apache webserver with PHP, mod_rewrite and imagemagick is up an running
2. Place the contents of this git project to your webroot or somewhere else (e.g. {document_root}/lib/fleximg/) and install requirements using ```$ bower install```
3. If you already have a .htaccess file (in {document_root}/.htaccess) put the following lines in 

		<IfModule mod_rewrite.c>
		RewriteEngine On

		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule img/scale/. /scale.php [L]

		</IfModule>

4. Open demo.php to see if it works. You should see an image with cows in three different sizes.
5. To insert into your existing projects change the src attribute key in your img tags to data-src and load the following scripts

		```
			<script src="/components/jquery/jquery.js"></script>

			<script src="/components/hammerjs/dist/jquery.hammer.js"></script>

			<script src="/scale.js"></script>
		```

6. Init fleximg

		```javascript
		<script>
			scale.init({
				onResize:true // default
				onPinchIn:true, // default
				onPinchOut:true, // default
				onLoad:true, // default
				steps:50 // default
			});
		</script>
		```


##Options

###steps
If the exact display size of is always roundet up so it can be evenly divided by the steps value to make the caching more efficient and prevent creating thousands of versions of one file.

###onResize
Image sizes get readjusted on window resize event

###onPinchIn
Image sizes get readjusted on window resize event

###onPinchOut
Image sizes get readjusted on window resize event

###onPinchOut
Image sizes get readjusted on window resize event

###onResize
Image sizes get readjusted on window resize event


##How it works
1. Set the src of img tags to the data-src attribute and make sure to create style definition which affect the image dimension.
2. After the page loads scale.js will be executed and check all img tags for data-src attributes. If found it will set the src of the img to ```/img/scale/{IMG_WIDTH}/{IMG_HEIGHT}/{IMG_FILEPATH}```.
3. If that file exists it will be delivered by the apache. If there is no file the request will be passed to scale.php which will scale the image to the requested dimensions, save it to the desired path and redirect to it again.

##MIT license
Copyright (c) 2013 Max Tobias Weber


##additional copyright info
###assets
img/test.jpg (2013 Loren Kerns http://www.flickr.com/photos/lorenkerns/9262656978/)