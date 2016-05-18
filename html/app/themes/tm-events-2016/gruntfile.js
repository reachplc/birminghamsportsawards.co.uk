module.exports = function( grunt ) {

  // Project configuration.
  grunt.initConfig({

    //  Config
    pkg: grunt.file.readJSON( 'package.json' ),

    //  Build Site

    watch: {
      files: ['less/**/*.less', 'bower_components/**/*'],
      tasks: ['dev'],
      options: {
        livereload: true
      }
    },

    // Compile

    less: {
      development: {
        options: {
          paths: ['']
        },
        files: {
          'style.css': ['less/global.less'],
          'editor-style.css': ['less/editor-style.less'],
          'rtl.css': ['less/rtl.less']
        }
      },
      production: {
        options: {
          compress: true
        },
        files: {
          'style.css': ['less/global.less'],
          'editor-style.css': ['less/editor-style.less'],
          'rtl.css': ['less/rtl.less']
        }
      }
    },

    svg2png: {
      gui: {
        files: [{
          cwd: '<%= grunt.config.get("dest") %>/static/gui/',
          src: ['**/*.svg'],
          dest: '<%= grunt.config.get("dest") %>/static/gui/'
        }]
      }
    },

    // Validate

    htmlhint: {
      options: {
        'tag-pair': true,
        'tagname-lowercase': true,
        'attr-lowercase': true,
        'attr-value-double-quotes': true,
        'doctype-first': true,
        'spec-char-escape': true,
        'id-unique': true,
        'style-disabled': true,
        'src-not-empty': true,
        'img-alt-require': true
      },
      src: ['<%= grunt.config.get("dest") %>/**/*.html']

    },

    csslint: {
      options: {
        'adjoining-classes': false,
        'box-model': false,
        'box-sizing': false,
        'regex-selectors': false,
        'universal-selector': false,
        'font-sizes': false //  Until CSSLint has the option to set an ammount
      },
      src: ['<%= grunt.config.get("dest") %>/static/css/*.css']
    },

    jshint: {
      options: {
        browser: true,
        curly: true,
        eqeqeq: true,
        eqnull: true,
        indent: 2,
        laxbreak: true,
        laxcomma: true,
        quotmark: 'single',
        trailing: true,
        undef: true,
        globals: {
          console: true,
          module: true,
          jQuery: true,
          Modernizr: true
        }
      },
      src: ['gruntfile.js', 'web/_includes/js/*.js']
    },

    // Optimise

    imagemin: {
      options: {
        optimizationLevel: 3
      },
      dev: {
        files: [{
          expand: true,
          cwd: '<%= grunt.config.get("dest") %>/static/gui',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: '<%= grunt.config.get("dest") %>/static/gui'
        }, {
          expand: true,
          cwd: '<%= grunt.config.get("dest") %>/static/media',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: '<%= grunt.config.get("dest") %>/static/media'
        }]
      }
    }

  });

  // Tasks

  grunt.loadNpmTasks( 'grunt-contrib-watch' );
  grunt.loadNpmTasks( 'grunt-contrib-less' );
  grunt.loadNpmTasks( 'grunt-htmlhint' );
  grunt.loadNpmTasks( 'grunt-contrib-csslint' );
  grunt.loadNpmTasks( 'grunt-contrib-jshint' );
  grunt.loadNpmTasks( 'grunt-contrib-imagemin' );
  grunt.loadNpmTasks( 'grunt-svg2png' );

  // Options

  grunt.registerTask( 'default', ['dev', 'serve'] );
  grunt.registerTask( 'test', ['htmlhint', 'csslint', 'jshint'] );
  grunt.registerTask( 'optim', ['imagemin'] );
  grunt.registerTask( 'dev', ['less:development'] );
	grunt.registerTask( 'build', ['less:production'] );
  grunt.registerTask( 'serve', ['watch'] );

};
