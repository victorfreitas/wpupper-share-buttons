module.exports = function(grunt) {

  var sassSiteOptions = {};

  if (process.env.NODE_ENV === 'production') {
    sassSiteOptions.sourcemap = 'none';
    sassSiteOptions.style = 'compressed';
  }

	function getObjectConcat(type) {
		return {
			src : [
				'<%= package.jsroot %>/libs/*.js',
				'<%= package.jsroot %>/' + type + '/libs/*.js',
				'<%= package.jsroot %>/vendor/*.js',
				'<%= package.jsroot %>/' + type + '/vendor/*.js',
				'<%= package.jsroot %>/' + type + '/app/*.js',
				'<%= package.jsroot %>/' + type + '/boot.js'
			],
			dest : ''.concat('build/', type, '.js'),
		};
  }

	var config = {
    package : grunt.file.readJSON( 'package.json' ),

    clean: {
      options: {
        force: true,
      },
      build: [''.concat(__dirname, '/build')],
    },

		concat : {
		    options : {
				separator : ';'
		    },
		    admin : getObjectConcat( 'admin' ),
		    front : getObjectConcat( 'front' )
  		},

		sass: {
			site: {
				options: sassSiteOptions,
				files: {
					'build/admin.css': '<%= package.sassadmin %>/admin.scss',
					'build/style.css': '<%= package.sassfront %>/style.scss'
				}
			},
		},

		handlebars: {
		    options: {
		    	namespace   : 'WPUSB.Templates',
				processName : function(filePath) {
				    return filePath.replace( /handlebars\/(.+)(\.hbs)/, '$1' );
				}
		    },
			dest: {
		        files: {
		            "<%= package.jsroot %>/admin/vendor/handlebars.templates.js" : ["handlebars/**/*.hbs"]
		        }
			}
		},

	    makepot : {
	        target : {
	            options : {
	                type          : 'wp-plugin',
	                domainPath    : '/<%= package.dirLang %>',
	                mainFile      : '<%= package.slug %>.php',
	                exclude       : ['node_modules/.*', '.sass-cache/.*', 'Vendor/.*', 'assets/.*', 'handlebars/.*'],
	                include       : ['.*.php'],
	                updatePoFiles : true,
	                potHeaders    : {
	                	'poedit'                        : true,
						'language'                      : 'en',
						'plural-forms'                  : 'nplurals=2; plural=(n != 1);',
						'Last-Translator'               : 'Victor Freitas <victorfreitasdev@gmail.com>',
						'x-poedit-country'              : 'United States',
						'x-poedit-sourcecharset'        : 'UTF-8',
						'x-poedit-keywordslist'         : '__;_e;__ngettext:1,2;_n:1,2;__ngettext_noop:1,2;_n_noop:1,2;_c;_nc:1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;',
						'x-poedit-basepath'             : '../',
						'x-poedit-searchpath-0'         : '.',
						'x-poedit-bookmarks'            : '',
						'x-textdomain-support'          : 'yes',
						'X-Poedit-SearchPath-0'         : 'Config',
						'X-Poedit-SearchPath-1'         : 'Controller',
						'X-Poedit-SearchPath-2'         : 'Helper',
						'X-Poedit-SearchPath-3'         : 'Model',
						'X-Poedit-SearchPath-4'         : 'Templates',
						'X-Poedit-SearchPath-5'         : 'View',
						'X-Poedit-SearchPath-6'         : 'Widget',
						'X-Poedit-SearchPath-7'         : '<%= package.slug %>.php',
						'X-Poedit-SearchPathExcluded-0' : 'node_modules',
						'X-Poedit-SearchPathExcluded-1' : 'assets',
						'X-Poedit-SearchPathExcluded-2' : 'Vendor',
						'X-Poedit-SearchPathExcluded-3' : 'handlebars'
	                }
	            }
	        }
	    },

  		jshint: {
			options: {
				jshintrc : true
			},
    		beforeconcat : ['<%= concat.admin.src %>', '<%= concat.front.src %>']
  		},

  		uglify : {
			site : {
				files : {
					'<%= concat.admin.dest %>' : '<%= concat.admin.dest %>',
					'<%= concat.front.dest %>' : '<%= concat.front.dest %>'
				}
			}
    	},

		watch: {
		    site : {
		    	files : ['<%= concat.admin.src %>', '<%= concat.front.src %>'],
		    	tasks : ['jshint', 'concat']
		    },
			css : {
				files : ['<%= package.sassroot %>/**/*.scss'],
				tasks : ['sass:site']
			},

			templates : {
				files : ['handlebars/**/*.hbs'],
				tasks : ['handlebars:dest']
			},
  		}
	};

	require('time-grunt')(grunt);

	grunt.initConfig( config );

  grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-handlebars' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );

	grunt.registerTask( 'build', ['clean', 'jshint', 'concat', 'uglify', 'sass:site', 'handlebars:dest'] );
};
