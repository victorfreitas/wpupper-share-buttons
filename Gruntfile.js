module.exports = function(grunt) {

	function getObjectConcat(folder) {
		return {
			src : [
				'<%= package.jsroot %>/libs/*.js',
				'<%= package.jsroot %>/' + folder + '/libs/*.js',
				'<%= package.jsroot %>/vendor/*.js',
				'<%= package.jsroot %>/' + folder + '/vendor/*.js',
				'<%= package.jsroot %>/' + folder + '/app/*.js',
				'<%= package.jsroot %>/' + folder + '/boot.js'
			],
			dest : '<%= package.jsroot %>/' + folder + '/built.js',
		};
	}

	function removeExtension(filePath) {
	    var template = filePath.replace( /handlebars\/(.*)(\/\w+\.hbs)/, '$1' );
	    return template.split( '/' ).join( '.' );
	}

	var config = {
		package : grunt.file.readJSON( 'package.json' ),

		concat : {
		    options : {
				separator : ';'
		    },
		    admin : getObjectConcat( 'admin' ),
		    front : getObjectConcat( 'front' )
  		},

		sass: {
			site: {
				options: {
					style: 'compressed',
					'sourcemap=none': '',
				},
				files: {
					'<%= package.cssroot %>/admin.css': '<%= package.cssadmin %>/admin.scss',
					'<%= package.cssroot %>/style.css': '<%= package.cssfront %>/style.scss'
				}
			},
		},

		handlebars: {
		    options: {
		    	namespace   : 'WPUSB.Templates',
				processName : removeExtension
		    },
			all: {
		        files: {
		            "<%= package.jsroot %>/admin/vendor/handlebars.templates.js" : ["handlebars/**/*.hbs"]
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
				files : ['<%= package.cssroot %>/**/*.scss'],
				tasks : ['sass:site']
			},

			templates : {
				files : ['handlebars/**/*.hbs'],
				tasks : ['handlebars:all']
			},
  		}
	};

	grunt.initConfig( config );

	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-handlebars-compiler' );

	grunt.registerTask( 'deploy', ['jshint', 'concat', 'uglify', 'sass:site', 'handlebars:all'] );
};