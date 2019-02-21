const gulp = require('gulp'),
  gulpLoadPlugins = require('gulp-load-plugins'),
  plugins = gulpLoadPlugins(),
  sourcemaps = require('gulp-sourcemaps'),
  streamqueue = require('streamqueue'),
  urladjuster = require('gulp-css-url-adjuster'),
  imageminJpegRecompress = require('imagemin-jpeg-recompress'),
  imageminPngquant = require('imagemin-pngquant'),
  del = require('del'),
  glob = require('glob'),
  fs = require('fs');


gulp.task('less', function () {
  glob.sync('less/*').forEach(function (path_each) {
    if (fs.statSync(path_each).isDirectory()) {
      gulp.src(path_each + "/*.less")
        .pipe(plugins.plumber())
        .pipe(plugins.concat('style.css'))
        .pipe(plugins.less())
        .pipe(urladjuster({
          replace: ['../../', '../../../']
        }))
        .pipe(plugins.autoprefixer([
          'ios_saf >= 6',
          'ie 10',
          'opera 12',
          'last 5 versions'
        ]))
        .pipe(plugins.csso())
        .pipe(gulp.dest(function (file) {
          return "css/" + path_each;
        }))
        .pipe(plugins.notify({message: 'Собран, чанк'}));
    }
  });

});

gulp.task('css_vendor', function () {
  return gulp.src('css/vendor/*.css')
    .pipe(plugins.plumber())
    .pipe(plugins.concat('vendor.css'))
    .pipe(plugins.autoprefixer([
      'ios_saf >= 6',
      'ie 10',
      'opera 12',
      'last 5 versions'
    ]))
    .pipe(gulp.dest('css/less'))
    .pipe(plugins.notify({message: 'Вендор css собрались'}));
});

gulp.task('add_theme_header', ['build'], function () {
  return streamqueue({objectMode: true},
    gulp.src('css/theme_name.css'),
    gulp.src('style.css')
  )
    .pipe(plugins.concat('style.css'))
    .pipe(gulp.dest('./'))
    .pipe(plugins.notify({message: 'Добавлен заголовок темы'}));
});

gulp.task('build', ['less', 'css_vendor'], function () {
  return streamqueue({objectMode: true},
    gulp.src('css/vendor/theme_name.css'),
    gulp.src('css/less/vendor.css'),
    gulp.src('css/less/common_critical/style.css')
  )
    .pipe(sourcemaps.init())
    .pipe(plugins.concat('css/opt/tmp_concat.css'))
    .pipe(urladjuster({
      replace: ['../../../', '']
    }))
    .pipe(plugins.csso({
      comments: false
    }))
    .pipe(plugins.rename('style.css'))
    .pipe(gulp.dest('./'))
    .pipe(plugins.notify({message: 'Оптимизация, прошла'}));
});

gulp.task('js', function () {
  return gulp.src([
    'js/*.js',
    '!js/*.min.js',
    '!js/vendor/**/*.js'
  ])
    .pipe(plugins.plumber())
    .pipe(plugins.uglify({
      compress: true,
    }))
    .pipe(plugins.rename({
      extname: ".js",
      suffix: ".min"
    }))
    .pipe(gulp.dest(function (file) {
      return file.base;
    }))
    .pipe(plugins.notify({message: 'Скрипты темы собрались'}));
});

gulp.task('svg', function () {
  return gulp.src('images/**/*.svg')
    .pipe(plugins.svgo())
    .pipe(gulp.dest(function (file) {
      return file.base;
    }))
    .pipe(plugins.notify({message: 'SVG оптимизированы'}));
});

gulp.task('img_optimization', function () {
  return gulp.src([
    'images/**/*.png',
    'images/**/*.jpeg',
    'images/**/*.jpg'
  ])
    .pipe(plugins.plumber())
    .pipe(plugins.imagemin([
      plugins.imagemin.gifsicle({interlaced: true}),
      imageminJpegRecompress({
        progressive: true,
        max: 80,
        min: 70
      }),
      imageminPngquant({quality: '80'}),
      plugins.imagemin.svgo({plugins: [{removeViewBox: true}]})
    ]))
    .pipe(gulp.dest(function (file) {
      return file.base;
    }))
});

gulp.task('clean', function (cb) {
  del(['less/maps/*'], cb);
});

gulp.task('watch', function () {
  gulp.watch(['less/**/*.less'], ['add_theme_header']);
  gulp.watch(
    [
      'js/*.js',
      '!js/*.min.js',
      '!js/vendor/**/*.js'
    ],
    ['js']
  );
});

gulp.task('default', ['watch', 'clean']);

