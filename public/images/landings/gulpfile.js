var gulp         = require('gulp'),
		sass         = require('gulp-sass'),
		browserSync  = require('browser-sync'),
		concat       = require('gulp-concat'),
		uglify       = require('gulp-uglify-es').default,
		cleancss     = require('gulp-clean-css'),
		autoprefixer = require('gulp-autoprefixer'),
		rsync        = require('gulp-rsync'),
		newer        = require('gulp-newer'),
		rename       = require('gulp-rename'),
		// responsive   = require('gulp-responsive'),
		del          = require('del');
		svgSprite       = require('gulp-svg-sprite');

// Scripts & JS Libraries
gulp.task('scripts', function() {
	return gulp.src([
		'js/jquery.min.js', // Optional jQuery plug-in (npm i --save-dev jquery)
		'js/aos.js', // Optional jQuery plug-in (npm i --save-dev jquery)
		'js/jquery.smartmenus.js', // Optional jQuery plug-in (npm i --save-dev jquery)
		'js/slick.js', // Optional jQuery plug-in (npm i --save-dev jquery)
		'js/sweetalert2.all.min.js', // Optional jQuery plug-in (npm i --save-dev jquery)
		'js/_lazy.js', // JS library plug-in example
		'js/_custom.js', // Custom scripts. Always at the end
		'js/_googleMap.js', // initMap script
		])
	.pipe(concat('scripts.min.js'))
	.pipe(uglify()) // Minify js (opt.)
	.pipe(gulp.dest('js'))
	.pipe(browserSync.reload({ stream: true }))
});

// Custom Styles
gulp.task('styles', function() {
	return gulp.src('sass/**/*.sass')
	.pipe(sass({ outputStyle: 'expanded' }))
	.pipe(concat('styles.min.css'))
	.pipe(autoprefixer({
		grid: true,
		overrideBrowserslist: ['last 10 versions']
	}))
	.pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Optional. Comment out when debugging
	.pipe(gulp.dest('css'))
	.pipe(browserSync.stream())
});

//  dd styles TEST
// gulp.task("watch", function() {
// 	console.log('its work');
// 	gulp.watch('sass/_landing3.sass', gulp.parallel('styles'));
// });