(function() {
'use strict';

/* global require */
var $g = require('gulp')
var $p = require('gulp-load-plugins')()
var $q = require('run-sequence')
var js = {
  'site.js': [
    'site/js/site.yii.js',
    'site/js/site.class.js', 
    'site/js/site.jquery.fn.js',
    'site/js/site.app.js',
    'site/js/site.actions.js',
    'site/js/site.js'
  ],
  'yii.js': [
    '../../vendor/yiisoft/yii2/assets/yii.js', 
    '../../vendor/yiisoft/yii2/assets/yii.gridView.js',
    '../../vendor/yiisoft/yii2/assets/yii.validation.js',
    '../../vendor/yiisoft/yii2/assets/yii.activeForm.js',
    '../../vendor/yiisoft/yii2/assets/yii.captcha.js'
  ],
  'jquery.plugins.js': [
    'site/js/plugins/jquery.pjax.js'
  ]
}
var minjs = {
  'site.min.js': 'dist/js/site.js',
  'yii.min.js': 'dist/js/yii.js',
  'jquery.plugins.min.js': 'dist/js/jquery.plugins.js'
}
var css = {
  'site.less': 'site/less/site.less'
}

function concat(src, file) {
  return function() {
    return $g.src(src)
      .pipe($p.sourcemaps.init({loadMaps: true}))
      .pipe($p.concat(file, {newLine: '\n'}))
      .pipe($p.sourcemaps.write('maps/'))
      .pipe($g.dest('dist/js/'))
  }
}

function uglify(src, file) {
  return function() {
    return $g.src(src)
      .pipe($p.plumber())
      .pipe($p.sourcemaps.init({loadMaps: true}))
      .pipe($p.uglify())
      .pipe($p.rename(file))
      .pipe($p.sourcemaps.write('maps/'))
      .pipe($g.dest('dist/js/'))
  }
}

function less(src, file) {
  return function() {
    return $g.src(src)
      .pipe($p.plumber())
      .pipe($p.sourcemaps.init({loadMaps: true}))
      .pipe($p.less())
      // .pipe($p.minifyCss())
      .pipe($p.sourcemaps.write('maps/'))
      .pipe($g.dest('dist/css/'))
  }
}

function tasks() {
  var k
  for (k in js) {
    if (js.hasOwnProperty(k)) {
      $g.task(k, concat(js[k], k))
    }
  }

  for (k in minjs) {
    if (minjs.hasOwnProperty(k)) {
      $g.task(k, uglify(minjs[k], k))
    }
  }

  for (k in css) {
    if (css.hasOwnProperty(k)) {
      $g.task(k, less(css[k], k))
    }
  }
}

// Register tasks.
tasks()

$g.task('lint', function() {
  return $g.src('site/js/*.js')
    .pipe($p.jshint())
    .pipe($p.jshint.reporter())
})

$g.task('bootstrap.less', function() {
  return $g.src('site/less/bootstrap-3.2.0/less/bootstrap.less')
    .pipe($p.plumber())
    .pipe($p.sourcemaps.init({loadMaps: true}))
    .pipe($p.less())
    // .pipe($p.minifyCss())
    .pipe($p.sourcemaps.write('.'))
    .pipe($g.dest('dist/bootstrap/css/'))
})

$g.task('watch', function() {
  $g.watch('site/js/*.js', ['site.js'])
  $g.watch('dist/js/site.js', ['site.min.js'])

  $g.watch('site/less/bootstrap-3.2.0/less/variables.less', ['site.less', 'bootstrap.less'])
  $g.watch('site/less/*.less', ['site.less'])

  $p.livereload.listen()
  $g.watch(['dist/**', '!dist/**/maps/**', '!dist/**/*.min.js'], function(file) {
    $p.livereload.changed(file.path)
  })
})

$g.task('default', function() {
  $q(
    ['site.js', 'yii.js', 'jquery.plugins.js', 'site.less', 'bootstrap.less'],
    ['site.min.js', 'yii.min.js', 'jquery.plugins.min.js']
  )
})

})()
