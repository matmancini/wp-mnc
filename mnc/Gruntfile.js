/*global module:false*/
module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		banner: '/*!\n<%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
		'<%= grunt.template.today("yyyy.mm-dd") %>' +
		' - <%= pkg.homepage %>\n' +
		'Author: <%= pkg.author %>\n*/\n',

		clean: {
			css: [
				'dist/css/*'
			],
			js: [
				'dist/js/*'
			],
			jsLib: [
				'dist/js/lib/'
			],
			jsPlugins: [
				'dist/js/plugins*.*'
			],
			jsScript: [
				'dist/js/script*.*'
			],
		},

		sass: {
			dist: {
				options: {
					style: 'compressed',
					sourcemap: true
				},
				files: {
					'dist/css/main.min.css': 'src/scss/main.scss'
				}
			},
			dev: {
				options: {
					style: 'expanded',
					sourcemap: true
				},
				files: {
					'dist/css/main.css': 'src/scss/main.scss'
				}
			}
		},

		copy: {
			jsLib: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['src/js/lib/*'],
						dest: 'dist/js/lib/'
					}
				]
			}
		},

		concat: {
			options: {
				banner: '<%= banner %>'
			},
			jsPlugins: {
				src: [
					'src/js/plugins/*.js',
				],
				dest: 'dist/js/plugins.js'
			},
			jsScript: {
				src: [
					'src/js/script.js',
				],
				dest: 'dist/js/script.js'
			}
		},

		uglify: {
			options: {
				banner: '<%= banner %>',
				sourceMap: true
			},
			plugins: {
				src: 'dist/js/plugins.js',
				dest: 'dist/js/plugins.min.js'
			},
			script: {
				src: 'dist/js/script.js',
				dest: 'dist/js/script.min.js'
			}
		},

		jshint: {
			options: {
				curly: true,
				eqeqeq: true,
				immed: true,
				latedef: true,
				newcap: true,
				noarg: true,
				sub: true,
				undef: true,
				unused: true,
				boss: true,
				eqnull: true,
				browser: true,
				globals: {
					'jQuery': true,
					'Modernizr': true,
					'console': true,
					'MNC': true
				}
			},
			gruntfile: {
				src: 'Gruntfile.js'
			},
			script: {
				src: 'src/js/script.js'
			}
		},

		watch: {
			css: {
				files: ['src/scss/*.scss'],
				tasks: ['sass:dev']
			},
			jsLib: {
				files: ['src/js/lib/*.*'],
				tasks: ['clean:jsLib', 'copy:jsLib']
			},
			jsScript: {
				files: ['src/js/script.js'],
				tasks: ['jshint:script', 'concat:jsScript']
			},
			jsPlugins: {
				files: ['src/js/plugins/*.js'],
				tasks: ['concat:jsPlugins']
			},
			gruntfile: {
				files: 'Gruntfile.js',
				tasks: ['jshint:gruntfile']
			}
		}
	});

	// These plugins provide necessary tasks.
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task.
	grunt.registerTask('build', ['jshint', 'clean', 'sass', 'copy', 'concat', 'uglify']);

};
