fleximg_js = {
  init: function(options) {

    if (typeof options === 'undefined') options = {};

    fleximg_js.applyOptions(options);

    fleximg_js.applyImagecacheUrl();


    setTimeout(fleximg_js.refresh, 500);
  },
  defaultOptions: {
    fireOnPinchIn: true,
    fireOnPinchOut: true,
    fireOnPinch: true,
    fireOnLoad: true,
    fireOnResize: true,
    steps: 50,
    img_folder: '/img',
    hidpi_multiplier: 1,
    remote_imagecache_url: false,
    imagecache_folder: 'fleximg_scale'
  },
  getOptionsObject: function(options) {
    return $.extend(fleximg_js.defaultOptions, options);
  },
  applyImagecacheUrl: function() {
    if (fleximg_js.remote_imagecache_url) {
      fleximg_js.img_folder = fleximg_js.remote_imagecache_url;
    }
  },
  applyOptions: function(options) {
    options = fleximg_js.getOptionsObject(options);

    for (var key in options) {
      if (options.hasOwnProperty(key)) {
        switch (key) {
          case 'fireOnPinchIn':
            if (typeof $().hammer !== 'undefined') {
              if (options[key]) {
                $(window).hammer().on("pinchin", fleximg_js.latestResizeRefresh);
              }
            }
            break;
          case 'fireOnPinchOut':
            if (typeof $().hammer !== 'undefined') {
              if (options[key]) {
                $(window).hammer().on("pinchout", fleximg_js.latestResizeRefresh);
              }
            }
            break;
          case 'fireOnLoad':
            if (options[key]) {
              $(window).load(fleximg_js.readjust);
            }
            break;
          case 'fireOnPinch':
            if (typeof $().hammer !== 'undefined') {
              if (options[key]) {
                $(window).hammer().on("pinch", fleximg_js.latestResizeRefresh);
              }
            }
            break;
          case 'fireOnResize':
            if (options[key]) {
              $(window).resize(fleximg_js.latestResizeRefresh);
            }
            break;
          default:
            fleximg_js.setOption(key, options[key]);
            break;
        }
      }
    }
  },
  setOption: function(key, value) {
    fleximg_js[key] = value;
  },
  readjust: function() {
    $('img[data-src]').each(function(idx, item) {
      // calculate desired img width
      var width = parseInt($(item).width(), 10);
      width = Math.floor(width * fleximg_js.getZoomRatio() * fleximg_js.getDevicePixelRatio());

      if (fleximg_js.steps) width = fleximg_js.applySteps(width);

      var resize = false;

      // check if resize is necessary
      if (typeof $(item).attr('current-size') === 'undefined') {
        resize = true;
      } else if (parseInt($(item).attr('current-size'), 10) < width &&
        width > 0) {
        resize = true;
      }

      var data_src = $(item).attr('data-src');
      if (data_src.indexOf('http://') === 0 || data_src.indexOf('https://') === 0) data_src = data_src.split('/').splice(3).join('/');
      if (data_src[0] !== '/') data_src = '/' + data_src;

      // [re]write img tag src
      if (resize) {

        $(item).attr('current-size', width);
        $(item).attr('src', fleximg_js.img_folder + '/' + fleximg_js.imagecache_folder + '/' + width + '/0' + data_src);


      } else if (typeof $(item).attr('src') === 'undefined') {
        $(item).attr('src', data_src);
      }
    });
  },
  applySteps: function(width) {
    if (width % fleximg_js.steps) return width + fleximg_js.steps - (width % fleximg_js.steps);
    return width;
  },
  getZoomRatio: function() {
    var ratio = $(document).width() / window.innerWidth;

    if (isNaN(ratio)) return 1;

    ratio = ratio * fleximg_js.hidpi_multiplier;
    return ratio;
  },
  getDevicePixelRatio: function() {
    var ratio = 1;

    if (typeof window.devicePixelRatio !== 'undefined') {
      ratio = window.devicePixelRatio;
    }
    return ratio;
  },
  // resize throttle
  latestResizeRefresh: function() {

    if (fleximg_js.latestResize === null) setTimeout(fleximg_js.latestResizeCheck, fleximg_js.wait);

    fleximg_js.latestResize = new Date();

  },
  latestResizeCheck: function() {
    if (fleximg_js.latestResize !== null) {
      if (fleximg_js.latestResize.getTime() + fleximg_js.wait < new Date().getTime()) {
        fleximg_js.readjust();

        fleximg_js.latestResize = null;
      } else {
        setTimeout(fleximg_js.latestResizeCheck, fleximg_js.wait);
      }
    }
  },
  wait: 1000,
  latestResize: null
};

fleximg_js.refresh = fleximg_js.latestResizeRefresh;