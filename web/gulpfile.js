var gulp = require('gulp');
var browserSync = require('browser-sync').create()
var compass = require('gulp-compass');
var plumber = require('gulp-plumber');
var inject = require('gulp-inject');
var watch = require('gulp-watch');
var uncss = require('gulp-uncss');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var rev = require('gulp-revv');
var revReplace = require('gulp-rev-replace');
var processhtml = require('gulp-processhtml');
var rimraf = require('rimraf');
var jsmin = require('gulp-jsmin');
var fs = require('fs');
var makedir = require('makedir');


/*******************************************************************************
 * src
 *******************************************************************************/

gulp.task('version-js', function(callback) {
  var package_json = require('./package.json');
  var str = 'var version = "' + package_json['version'] + '";';
  var fs = require('fs');
  fs.open("./src/js/version.js", "w", function(err, fd) {
    var buf = new Buffer(str);
    fs.write(fd, buf, 0, buf.length, 0, function(err, written, buffer) {
      callback();
    });
  });
});


// 注入 controllers
gulp.task('inject-controllers', function() {

  var target = gulp.src('./src/index.html');
  var sources = gulp.src(['./src/js/controllers/**/*.js'], {
    read: false
  });

  return target.pipe(inject(sources, {
    name: 'controllers'
  })).pipe(gulp.dest('./src'));

});


// 注入 models
gulp.task('inject-models', function() {

  var target = gulp.src('./src/index.html');
  var sources = gulp.src(['./src/js/models/**/*.js'], {
    read: false
  });

  return target.pipe(inject(sources, {
    name: 'models'
  })).pipe(gulp.dest('./src'));

});


// 生成JS引用图片的地图
gulp.task('js-images-map', function(callback) {

  makedir.makedir('./dist/rev/js', function() {

    var str = 'var js_images = ';
    var map = {};
    var fs = require('fs'),
      fileList = [];

    function walk(path) {
      var dirList = fs.readdirSync(path);
      dirList.forEach(function(item) {
        if (fs.statSync(path + '/' + item).isDirectory()) {
          walk(path + '/' + item);
        } else {
          fileList.push(path + '/' + item);
          if (item.indexOf('js-') != -1) {
            var _path = path.substr(path.indexOf('images/') + 7) + '/';
            var img = _path + item;
            map[img] = img;
          }
        }
      });
    }

    walk('./src/images');

    str += JSON.stringify(map) + ';';

    // 制作JS引用文件
    fs.open("./src/js/images.js", "w", function(err, fd) {

      var buf = new Buffer(str);
      fs.write(fd, buf, 0, buf.length, 0, function(err, written, buffer) {
        // 制作JSON,供编译时使用
        fs.open("./dist/rev/js/images.json", "w", function(err, fd) {
          var buf = new Buffer(JSON.stringify(map));
          fs.write(fd, buf, 0, buf.length, 0, function(err, written, buffer) {
            console.log(str);
            callback();
          });
        });
      });

    });
  });
});


// compass 任务
gulp.task('compass', function() {

  return gulp.src('./src/sass/*.scss')
    .pipe(compass({
      config_file: './config.rb',
      css: './src/css',
      sass: './src/sass',
    }))
    .on('error', function(error) {
      // 捕获compass错误
      console.log(error);
      this.emit('end');
    })
    .pipe(browserSync.stream());
});


gulp.task('browser', function() {

  // compass 自动编译
  gulp.watch('./src/sass/**/*.scss', gulp.series('compass'));

  // 监听管理界面自动刷新
  watch(['./src/js/**/*.js', './src/index.html', './src/views/**/*.html','./src/templates/**/*.html'], browserSync.reload);

  // 监听安装界面
  watch(['./src/install/**/*.*'], browserSync.reload);

  return browserSync.init({
    server: {
      baseDir: "./"
    },
    port: 8080,
    startPath: '/src/'
  });
});

// 开启服务
gulp.task('default', gulp.series('compass', 'browser'), function(callback) {
  callback();
});


/*******************************************************************************
 * dist
 *******************************************************************************/


// 为图片打版本号
gulp.task('build-images', function() {
  return gulp.src(['./src/images/**/**.*'])
    .pipe(rev())
    .pipe(gulp.dest('./dist/images'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('./dist/rev/images'));

});


// 生成JS图片引用地图
gulp.task('build-images-map-js', function(callback) {

  var revJson = require('./dist/rev/images/rev-manifest.json');
  var imgJson = require('./dist/rev/js/images.json');

  for (var i in imgJson) {
    imgJson[i] = revJson[i];
  }

  var str = 'var js_images = ';
  str += JSON.stringify(imgJson) + ';';
  var fs = require('fs');

  makedir.makedir('./dist/js', function() {
    // 制作JS,供开发环境使用
    fs.open("./dist/js/images.js", "w", function(err, fd) {
      var buf = new Buffer(str);
      fs.write(fd, buf, 0, buf.length, 0, function(err, written, buffer) {
        callback();
      });
    });
  });
});

gulp.task('bulid-concat-js',function(){
  return gulp.src([
      './src/js/version.js',
      './dist/js/images.js',
      './src/js/helper.js',
      './src/js/config.js',
      './src/js/app.js',
      './src/js/models/*.js',
      './src/js/controllers/*.js'
    ])
    .pipe(concat('app.min.js'))
    .pipe(jsmin())
    .pipe(gulp.dest('./dist/js'));
});

// css 压缩，打版本号
gulp.task('build-css', function() {
  return gulp.src(['./src/css/*.css'])
    .pipe(minifyCss())
    .pipe(rev())
    .pipe(gulp.dest('./dist/css/'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('./dist/rev/css'));
});


gulp.task('build-js', function() {
  return gulp.src('./dist/js/**/*.js')
         .pipe(rev())
         .pipe(gulp.dest('./dist/js'))
         .pipe(rev.manifest())
         .pipe(gulp.dest('./dist/rev/js'));
});


gulp.task('build-replace-index', function() {
  var manifest = gulp.src("./dist/rev/**/*.json");
  return gulp.src(["./src/index.html"])
    .pipe(processhtml())
    .pipe(revReplace({
      manifest: manifest
    }))
    .pipe(gulp.dest('./dist'));
});


// 替换HTML模板里的资源版本号
gulp.task('build-replace-views', function() {
  var manifest = gulp.src("./dist/rev/**/*.json");
  return gulp.src(["./src/views/**/*.html"])
    .pipe(revReplace({
      manifest: manifest
    }))
    .pipe(gulp.dest('./dist/views'));
})


// 替换css里图片资源版本号
gulp.task('build-replace-css', function() {
  var manifest = gulp.src("./dist/rev/**/*.json");
  return gulp.src(["./dist/css/**/*.css"])
    .pipe(revReplace({
      manifest: manifest
    }))
    .pipe(gulp.dest('./dist/css'));
});

// 替换index.html资源版本文件
gulp.task('build-replace', gulp.series('build-replace-index', 'build-replace-views', 'build-replace-css'));


gulp.task('build-clean-dist', function(callback) {
  return rimraf('./dist', callback);
});

gulp.task('build-clean-rev', function(callback) {
  return rimraf('./dist/rev', callback);
});


// 清空生产环境文件
gulp.task('build-clean', gulp.series('build-clean-rev', 'build-clean-dist'));


// 复制bower内容到 dist
gulp.task('build-copy-bower', function() {
  return gulp.src(['./src/bower/**/*.*'])
    .pipe(gulp.dest('./dist/bower'));
});



gulp.task('build', gulp.series(
  'build-clean',
  'compass',
  'js-images-map',
  'version-js',
  'build-copy-bower',
  'build-images',
  'build-images-map-js',
  'bulid-concat-js',
  'build-js',
  'build-css',
  'build-replace'
));
