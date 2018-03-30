var gulp    = require('gulp');
var beep    = require('beepbeep');
var sass    = require('gulp-sass');
var uglify  = require('gulp-uglify');
var rename  = require('gulp-rename');
var compass = require('gulp-compass');
var plumber = require('gulp-plumber');
var using   = require('gulp-using');
var run     = require('gulp-run');

var onError = function(err) {
    beep(3, 1000);
    console.log(err.toString());
    this.emit("End");
}

/**
 * ---------------  BUNDLE JS  ----------------------------------------------------------
 */
var BundleJsConfig = {
    sourcePath: ['src/**/Resources/public/**/*.js', '!src/**/Resources/public/**/*.min.js'],
    destPath:   'web/bundles'
};

gulp.task('bundle_js', function() {
    gulp.src(BundleJsConfig.sourcePath)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest(BundleJsConfig.destPath));
});

/**
 * BUNDLE SASS
 */
var BundleSassConfig = {
    sourcePath: ['src/**/Resources/public/**/*.scss'],
    destPath:   'web/bundles'
};

gulp.task('bundle_sass', function() {
    gulp.src(BundleSassConfig.sourcePath)
        .pipe(using())
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(
            sass({outputStyle: 'compressed'})
            //.on('error', sass.logError())
        )
        .pipe(gulp.dest(function(file) {
            return file.base;
        }))
        .pipe(gulp.dest(BundleSassConfig.destPath))
});


/**
 * Bundle Images
 **/
var BundleImgConfig = {
  sourcePath: 'src/**/Resources/public/**/img/*.*',
  destPath:   'web/bundles'
};

gulp.task('bundle_img', function() {
    return gulp.src(BundleImgConfig.sourcePath)
        .pipe(using())
        .pipe(gulp.dest(BundleImgConfig.destPath));
});


//Dump bazinga translations
var JsTranslationsConfig = {
    sourcePath: 'src/**/translations/*.yml'
};

gulp.task('js_translations_dump', function() {
    return gulp.src(JsTranslationsConfig.sourcePath)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(run('php bin/console bazinga:js-translation:dump'));
});



gulp.task('watch', function () {
    gulp.watch(BundleJsConfig.sourcePath, ['bundle_js']);
    gulp.watch(BundleSassConfig.sourcePath, ['bundle_sass']);
    gulp.watch(BundleImgConfig.sourcePath, ['bundle_img']);
    //gulp.watch(JsTranslationsConfig.sourcePath, ['js_translations_dump']);
})

gulp.task('default', [
    'bundle_js', 'bundle_sass', 'bundle_img', 'watch'
]);
