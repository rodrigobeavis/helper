const gulp = require('gulp');
const image = require('gulp-image');

gulp.task('image', function () {
  gulp.src('./img/**')
    .pipe(image())
    .pipe(gulp.dest('./dest'));
});

gulp.task('default', ['image']);




// const gulp = require('gulp');
// const imagemin = require('gulp-imagemin');

// gulp.task('default', () =>
//     gulp.src('./img/*')
//     .pipe(imagemin())
//     .pipe(gulp.dest('./dest'))
// );
