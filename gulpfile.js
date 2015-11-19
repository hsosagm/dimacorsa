'use strict';
/*
* Dependencies
*/
var gulp = require('gulp'),
concat = require('gulp-concat'),
minifyCss = require('gulp-minify-css'),
notify = require("gulp-notify"),
livereload = require('gulp-livereload'),
uglify = require('gulp-uglify');

/*
* CSS configuration
*/
gulp.task('cssMain', function () {
	return gulp.src([
        'app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
        'app/assets/components/bower/font-awesome/css/font-awesome.min.css',
        'app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
	])
	.pipe(concat('main.css'))
	.pipe(gulp.dest('public/css/'))
});

gulp.task('cssCustom', function () {
	return gulp.src([
        'app/assets/css/**/*.css',
	])
	.pipe(concat('custom.css'))
	.pipe(gulp.dest('public/css/'))
	.pipe(livereload())
});

gulp.task('cssProveedor', function () {
	return gulp.src([
	    'app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
	    'app/assets/components/bower/font-awesome/css/font-awesome.min.css',
	    'app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
	    'app/assets/components/bower/toastr/toastr.css',
	    'app/assets/css/datepicker-pickadate-custom.css',
	    'app/assets/css/theme/*.css',
	    'app/assets/css/toastr.css',
	    'app/assets/css/master-detail.css',
	    'app/assets/css/bootstrap-custom.css',
	    'app/assets/css/form.css',
	    'app/assets/css/table.css',
	    'app/assets/css/main.css',
	    'app/assets/css/autocomplete.css',
	    'app/assets/css/not-scroll.css',
	    'app/assets/css/consultas.css',
	    'app/assets/proveedor/css/*'
	])
	.pipe(concat('proveedor.css'))
	.pipe(gulp.dest('public/css/'))
    .pipe(livereload())
});

gulp.task('cssCliente', function () {
	return gulp.src([
        'app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
        'app/assets/components/bower/font-awesome/css/font-awesome.min.css',
        'app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
        'app/assets/components/bower/toastr/toastr.css',
        'app/assets/css/theme/*.css',
        'app/assets/css/toastr.css',
        'app/assets/css/bootstrap-custom.css',
        'app/assets/css/form.css',
        'app/assets/css/table.css',
        'app/assets/css/main.css',
        'app/assets/css/autocomplete.css',
        'app/assets/css/not-scroll.css',
        'app/assets/css/consultas.css',
        'app/assets/css/datepicker-pickadate-custom.css',
        'app/assets/cliente/css/*'
	])
	.pipe(concat('cliente.css'))
	.pipe(gulp.dest('public/css/'))
    .pipe(livereload())
});

/*
* JS configuration
*/
gulp.task('jsMain', function () {
	return gulp.src([
		'app/assets/components/bower/jquery/jquery.js',
        'app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
        'app/assets/components/bower/jquery-nicescroll/jquery.nicescroll.js',
        'app/assets/js/jpreloader-v2/js/jpreloader.js',
        'app/assets/components/bower/jquery.easing/js/jquery.easing.js',
        'app/assets/components/bower/datatables/media/js/jquery.dataTables.js',
        'app/assets/components/bower/highcharts/highcharts.js',
        'app/assets/components/bower/highcharts/highcharts-3d.js',
        'app/assets/components/bower/highcharts/modules/exporting.js',
        'app/assets/js/plugins/**/*.js'
	])
	.pipe(concat('main.js'))
	.pipe(gulp.dest('public/js/'))
});

gulp.task('jsCustom', function () {
	return gulp.src([
	    'app/assets/js/*.js',
	])
	.pipe(concat('custom.js'))
	.pipe(gulp.dest('public/js/'))
    .pipe(livereload())
});

gulp.task('jsProveedor', function () {
	return gulp.src([
        'app/assets/js/main.js',
        'app/assets/js/data-remote.js',
        'app/assets/js/impresiones.js',
        'app/assets/js/tema.js',
        'app/assets/proveedor/js/*'
	])
	.pipe(concat('proveedor.js'))
	.pipe(gulp.dest('public/js/'))
    .pipe(livereload())
});

gulp.task('jsCliente', function () {
	return gulp.src([
        'app/assets/js/main.js',
        'app/assets/js/data-remote.js',
        'app/assets/js/impresiones.js',
        'app/assets/js/ventas.js',
        'app/assets/js/cliente.js',
        'app/assets/js/tema.js',
        'app/assets/cliente/js/*'
	])
	.pipe(concat('cliente.js'))
	.pipe(gulp.dest('public/js/'))
    .pipe(livereload())
});

/*
* Concat all js files
*/
gulp.task('compress-js', ['cssMain', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor'], function() {
  return gulp.src('public/js/*.js')
    .pipe(uglify())
    .pipe(gulp.dest('public/js/'));
});

/*
* Minify all css files
*/
gulp.task('compress-css', ['cssMain', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor'], function() {
    return gulp.src('public/css/*.css')
    .pipe(minifyCss())
    .pipe(gulp.dest('public/css'));
});

/*
* Keep an eye on css, js, and PHP files for changes...
*/
gulp.task('watch', ['cssMain', 'cssCustom', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor'], function() {
    livereload.listen();
	gulp.watch('app/assets/js/*.js', ['jsCustom']);
	gulp.watch('app/assets/cliente/js/*.js', ['jsCliente']);
	gulp.watch('app/assets/proveedor/js/*.js', ['jsProveedor']);
    gulp.watch('app/assets/css/**/*.css', ['cssCustom']);
    gulp.watch('app/assets/proveedor/css/*.css', ['cssProveedor']);
    gulp.watch('app/assets/cliente/css/*.css', ['cssCliente']);
});

// .pipe(notify({ message: 'All done'}))
/*
* Fonts.
*/
gulp.task('fonts', function() {
    return gulp.src([
        'app/assets/components/bower/bootstrap/dist/fonts/glyphicons-halflings-regular.*',
        'app/assets/components/bower/font-awesome/fonts/fontawesome-webfont.*'
    ])
    .pipe(gulp.dest('public/fonts/'));
});

/*
* Default task will run only when you type the command gulp.
*/
gulp.task('default', ['cssMain', 'cssCustom', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor', 'watch']);

/*
* Task to run on production server.
*/
gulp.task('build', ['cssMain', 'cssCustom', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor', 'compress-js', 'compress-css', 'fonts']);

/*
* Task to run on production server without minify.
*/
gulp.task('update', ['cssMain', 'cssCustom', 'cssCliente', 'cssProveedor', 'jsMain', 'jsCustom', 'jsCliente', 'jsProveedor']);