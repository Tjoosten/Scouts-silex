//
// Gulpfile for asset management.
// -------------------------------------------
var gulp = require('gulp-help')(require('gulp'));
var pagespeed = require('psi');

// Gulp config.
// -------------------------------------------
var pageSpeedUri   = 'st-joris-turnhout.be';
var lessPath       = 'resources/less';
var fontsPath      = 'resources/fonts';
var javascriptPath = 'resources/javascript';

// Gulp tasks.
// -------------------------------------------

// Gulp default task.
gulp.task('default', 'The default task', function () {
    gulp.start('help');
});

// Run PageSpeed Insights -> Mobile
gulp.task('pagespeed-mobile', 'Get the pagespeed results for the mobile website.', function (callback) {
    return pagespeed.output(pageSpeedUri, {
        strategy: 'mobile'
    }, callback);
});

// Run the PageSpeed Insights -> desktop
gulp.task('pagespeed-desktop', 'Get the pagespeed results for the desktop website.', function (callback) {
    return pagespeed.output(pagespeedUri, {
        strategy: 'mobile'
    }, callback);
});
