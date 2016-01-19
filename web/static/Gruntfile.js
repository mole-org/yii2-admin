/*global module:false*/
// "grunt": "~0.4.2",
// "grunt-contrib-concat": "~0.3.0",
// "grunt-contrib-cssmin": "~0.10.0",
// "grunt-contrib-jshint": "~0.7.2",
// "grunt-contrib-less": "~0.11.3",
// "grunt-contrib-uglify": "~0.2.7",
// "grunt-contrib-watch": "~0.5.3",
// "grunt-includes": "~0.4.5",
module.exports = function(grunt) {
  'use strict';

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
      ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    concat: {
      options: {
        banner: '',
        stripBanners: true
      },
      plugins: {
        src: ['site/js/plugins/jquery.pjax.js'],
        dest: 'dist/js/jquery.plugins.js'
      },
      site: {
        src: [
          'site/js/site.yii.js',
          'site/js/site.class.js', 
          'site/js/site.jquery.fn.js',
          'site/js/site.app.js',
          'site/js/site.actions.js',
          'site/js/site.js'
        ],
        dest: 'dist/js/site.js'
      },
      yii: {
        src: [
          '../../vendor/yiisoft/yii2/assets/yii.js', 
          '../../vendor/yiisoft/yii2/assets/yii.gridView.js',
          '../../vendor/yiisoft/yii2/assets/yii.validation.js',
          '../../vendor/yiisoft/yii2/assets/yii.activeForm.js',
          '../../vendor/yiisoft/yii2/assets/yii.captcha.js'
        ],
        dest: 'dist/js/yii.js'
      }
    },
    uglify: {
      options: {
        banner: ''
      },
      site: {
        src: 'dist/js/site.js',
        dest: 'dist/js/site.min.js'
      },
      plugins: {
        src: 'dist/js/jquery.plugins.js',
        dest: 'dist/js/jquery.plugins.min.js'
      },
      yii: {
        src: 'dist/js/yii.js',
        dest: 'dist/js/yii.min.js'
      }
    },
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      src: {
        src: 'site/js/*.js'
      }
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      concat_site: {
        files: ['site/js/*.js'],
        tasks: ['concat:site', 'jshint:src']
      },
      concat_plugins: {
        files: ['site/js/plugins/*.js'],
        tasks: ['concat:plugins']
      },
      less_site: {
        files: ['site/less/*', 'site/less/bootstrap-3.2.0/less/variables.less'],
        tasks: ['less:site']
      },
      less_bootstrap: {
        files: ['site/less/bootstrap-3.2.0/less/variables.less'],
        tasks: ['less:bootstrap']
      }
    },
    less: {
      site: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'site.css.map',
          sourceMapFilename: 'dist/css/site.css.map'
        },
        files: {
          'dist/css/site.css': 'site/less/site.less'
        }
      },
      bootstrap: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'bootstrap.css.map',
          sourceMapFilename: 'dist/bootstrap/css/bootstrap.css.map'
        },
        files: {
          'dist/bootstrap/css/bootstrap.css': 'site/less/bootstrap-3.2.0/less/bootstrap.less'
        }
      }
    },
    cssmin: {
      options: {
        compatibility: 'ie8',
        keepSpecialComments: '*',
        noAdvanced: true
      },
      site: {
        files: {
          'dist/css/site.min.css': 'dist/css/site.css'
        }
      },
      bootstrap: {
        files: {
          'dist/bootstrap/css/bootstrap.min.css': 'dist/bootstrap/css/bootstrap.css'
        }
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task.
  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'less', 'cssmin']);

};
