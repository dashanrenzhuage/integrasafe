let gulp = require('gulp');

let lec = require('gulp-line-ending-corrector');

gulp.task('ReplaceLineEndings', function () {
    gulp.src('app/**/')
        .pipe(lec({
            verbose: true,
            eolc: 'LF',
            encoding: 'utf8'
        }))
        .pipe(gulp.dest('./app'));
    gulp.src('resources/**/')
        .pipe(lec({
            verbose: true,
            eolc: 'LF',
            encoding: 'utf8'
        }))
        .pipe(gulp.dest('./resources'));
});

gulp.task('migrateMDSource', function () {
	"use strict";
	gulp.src('node_modules/material-components-web/dist/material-components-web.min.css').pipe(gulp.dest('../public_html/css/libraries'));
	gulp.src('node_modules/material-components-web/dist/material-components-web.min.js').pipe(gulp.dest('../public_html/js/libraries'));
});

/**
 * https://github.com/scniro/gulp-clean-css
 * https://github.com/jakubpawlowicz/clean-css
 * @type (plugin)
 */
let cleanCSS = require('gulp-clean-css');

/**
 * https://github.com/contra/gulp-concat
 * @type (plugin)
 */
let concate = require('gulp-concat');

/**
 * https://github.com/sindresorhus/gulp-rev
 * @type {plugin}
 */
let rev = require('gulp-rev');

gulp.task('CleanCSS', () => {
    return gulp.src([
		'public/css/source/app.css',
		'public/css/source/integrasafe.css',
		'public/css/source/main.css',
		'public/css/source/materialize.css',
		'public/css/source/milestone.css',
        'public/css/libraries/bootstrap.3.3.7.css',
        'public/css/libraries/material-design-1.3.0.css',
    ])
        .pipe(cleanCSS({
                debug: true,
                level: {
                    1: {
                        all: true,
                        normalizeUrls: false
                    },
                    2: {restructureRules: true}
                }
            },
			function (details) {
                console.log(details.name + ': ' + details.stats.originalSize);
                console.log(details.name + ': ' + details.stats.minifiedSize);
            }))
        .pipe(concate('style.min.css'))
        .pipe(gulp.dest('../public_html/css/stage'))
        .pipe(rev())
        .pipe(gulp.dest('../public_html/css/release'))
        .pipe(rev.manifest({
            merge: true
        }))
        .pipe(gulp.dest('../public_html/css/release'));
});
