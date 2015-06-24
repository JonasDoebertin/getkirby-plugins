/*
    Initialize Gulp.js modules
 */
var gulp       = require('gulp'),
    sass       = require('gulp-sass'),
    autoprefix = require('gulp-autoprefixer'),
    minifyCSS  = require('gulp-minify-css'),
    uglify     = require('gulp-uglify'),
    concat     = require('gulp-concat'),
    rename     = require('gulp-rename'),
    include    = require('gulp-include'),
    replace    = require('gulp-replace'),
    clean      = require('gulp-clean');





/*
    Paths: JS Paths to include in javascript compilation
 */
var jsPaths = [
    'assets/__js/*.js'
];





/*
    Paths: SCSS Paths to include in CSS compilation
 */
var scssPaths = [
    'assets/__scss/**/*.scss'
];





/*
    Task: Compile and minify SCSS
 */
gulp.task('css', ['timestamps'], function() {
    return gulp.src(scssPaths)
        .pipe(sass({errLogToConsole: true}))
        .pipe(autoprefix('last 2 versions', '> 1%', 'ie 8', 'ie 9'))
        .pipe(minifyCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('assets/css'));
});





/*
    Task: Combine and uglify JS
 */
gulp.task('js', ['timestamps'], function() {
    return gulp.src(jsPaths)
        .pipe(include())
        .pipe(uglify({preserveComments: 'some'}))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('assets/js'));
});




/*
    Task: Insert timestamps into template files
 */
gulp.task('timestamps', function() {
        return gulp.src('site/snippets/**/*')
            .pipe(replace(/(@@)(?:\d+|timestamp)/ig, '$1' + new Date().getTime()))
            .pipe(gulp.dest('site/snippets'));
});





/*
    Task: Watcher
 */
gulp.task('watch', ['js', 'css'], function() {
    gulp.watch(scssPaths, ['css']);
    gulp.watch(jsPaths, ['js']);
});





/*
    Task: Default
 */
gulp.task('default', ['watch']);
