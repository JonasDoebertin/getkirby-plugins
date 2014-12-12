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
    replace    = require('gulp-replace-task'),
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
    Path: Folder path for a prepared deploy
 */
var deployBasePath = '__deploy/';





/*
    Paths: File Paths to include when preparing a deploy
 */
var deployIncludePaths = [
    '**/*',
    '.htaccess',
    '!{__deploy,__deploy/**}',
    '!{.git,.git/**}',
    '!assets/{__js,__js/**}',
    '!assets/{__scss,__scss/**}',
    '!assets/{__vendor,__vendor/**}',
    '!{node_modules,node_modules/**}',
    '!thumbs/**',
    '!.bowerrc',
    '!.gitignore',
    '!.gitmodules',
    '!bower.json',
    '!composer.{json,lock}',
    '!gulpfile.js',
    '!package.json',
    '!license.md',
    '!readme.md'
];

/*
    Paths: Deploying will add timestamps to this files
 */
var deployInsertPaths = [
    '__deploy/site/snippets/**/*'
];





/*
    Task: Compile and minify SCSS
 */
gulp.task('css', function() {
    return gulp.src(scssPaths)
        .pipe(sass({errLogToConsole: true}))
        .pipe(autoprefix('last 2 versions', '> 1%', 'ie 8', 'ie 9'))
        .pipe(minifyCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('assets/css'));
});





/*
    Task: Combine and uglify JS
 */
gulp.task('js', function() {
    return gulp.src(jsPaths)
        .pipe(include())
        .pipe(uglify({preserveComments: 'some'}))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('assets/js'));
});





/*
    Task: Clear deploy directory
 */
gulp.task('deploy-cleanup', function() {
    return gulp.src(deployBasePath, {read: false})
        .pipe(clean());
});


/*
    Task: Copy files for a deploy
 */
gulp.task('deploy-copy', ['deploy-cleanup', 'css', 'js'], function() {
    return gulp.src(deployIncludePaths)
        .pipe(gulp.dest(deployBasePath));
});


/*
    Task: Prepare a deploy and insert timestamps for cache busting
 */
gulp.task('deploy', ['deploy-copy'], function() {
    gulp.src(deployInsertPaths)
        .pipe(replace({
            patterns: [
                {
                    match:       'timestamp',
                    replacement: new Date().getTime()
                }
            ]
        }))
        .pipe(gulp.dest('__deploy/site/snippets/'));
});





/*
    Task: Watcher
 */
gulp.task('watch', function() {
    gulp.watch(scssPaths, ['css']);
    gulp.watch(jsPaths, ['js']);
});





/*
    Task: Default
 */
gulp.task('default', ['watch']);
