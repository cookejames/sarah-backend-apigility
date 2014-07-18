//Gruntfile
module.exports = function(grunt) {
	var jqueryUiTheme = 'cupertino';
	//set the global option isDev if given the --dev commandline parameter
	global.isDev = false;
	if (grunt.option('dev')) {
		global.isDev = true;
	}
	// Initializing the configuration object
	grunt.initConfig({
		// Task configuration
		less: {
			options: {
				compress: true,  //minifying the result
				sourceMap: (global.isDev) ? true : false,
				outputSourceFiles: true,
			},
			development: {
				files: {
					"public/css/site.css":"assets/less/site.less",
				}
	        }
		},
		cssmin: {
			combine: {
				files: {
					'public/css/site.css': [
                        'assets/css/**/*.css',
                        'bower_components/jquery-ui/themes/' + jqueryUiTheme + '/jquery-ui.css',
                        'bower_components/rickshaw/rickshaw.css',
                        'public/css/site.css',
                    ]
				}
			}
		},
		uglify: {
			options: {
				mangle: false,
				beautify: false,
				sourceMap: (global.isDev) ? true : false,
				sourceMapIncludeSources: true
			},
			development: {
				files: [
			        {
						'public/js/site.js': [
		  				    'bower_components/jquery/dist/jquery.js',
						    'bower_components/jquery-ui/ui/jquery-ui.js',
						    'bower_components/jquery-ui-touch-punch-valid/jquery.ui.touch-punch.js',
						    'bower_components/bootstrap/dist/js/bootstrap.js',
						    'bower_components/rickshaw/vendor/d3.min.js',
						    'bower_components/rickshaw/vendor/d3.layout.min.js',
						    'bower_components/rickshaw/rickshaw.js',
						    'bower_components/handlebars.js/dist/handlebars.runtime.js',
						    'assets/js/templates/compiled/index/**/*.js',
				          ],
					},
			        {
			        	expand: true,
			        	cwd: 'assets/js/',
			        	src: '**/*.js',
			        	dest: 'public/js/'
		    		}
				]
			},
		},
		copy: {
			development: {
				files: [
				        //copy bootstrap fonts
				        {
				        	expand: true,
				        	flatten: true,
				        	cwd: 'bower_components/bootstrap/dist/fonts/',
				        	src: '**',
				        	dest: 'public/fonts/bootstrap/'
		        		},
				        //copy jquery-ui images
				        {
				        	expand: true,
				        	flatten: true,
				        	cwd: 'bower_components/jquery-ui/themes/' + jqueryUiTheme + '/images/',
				        	src: '**',
				        	dest: 'public/css/images/'
		        		}
		        ]
			}
		},
		'install-dependencies': {
			options: {
				cwd: 'bower_components/handlebars.js/',
				isDevelopment: true
			}
		},
		run_grunt: {
			options: {
				log: true,
			},
			handlebars: {
				options: {
					task: ['build']
				},
				src: ['bower_components/handlebars.js/Gruntfile.js']
			}
		},
		handlebars: {
			options: {
				namespace: "DrHouse.Templates",
				processName: function(filePath) {
				    return filePath.replace('assets/js/templates/src/', '').replace(/\.hbs$/, '');
				}
			},
			templates: {
				files: [
			        {
			        	expand: true,
			        	cwd: 'assets/js/templates/src/',
			        	src: '**/*.hbs',
			        	dest: 'assets/js/templates/compiled/',
			        	ext: '.js'
			        }
				]
		    }
		},
		watch: {
			javascript: {
				files: [
				        'assets/js/**/*.js'
		        ],   
		        tasks: ['newer:uglify', 'newer:handlebars'], //tasks to run
			},
			handlebars: {
				files: [
				        'assets/js/templates/src/**/*.hbs'
		        ],   
		        tasks: ['newer:handlebars', 'newer:uglify'],
			},
	        less: {
	        	files: [
	        	        'assets/less/**/*.less'
    	        ], //watched files
	        	tasks: ['less', 'cssmin'], //tasks to run
	        },
	        css: {
	        	files: [
	        	        'assets/css/**/*.css'
    	        ], //watched files
	        	tasks: ['less', 'cssmin'], //tasks to run
	        },
	        public_html: {
	        	files: [
	        	        'public/**/*.{css,js}'
    	        ],
    	        options: {
    	        	livereload: true
    	        }
	        }
		}
	});

	// Plugin loading
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-newer');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-install-dependencies');
	grunt.loadNpmTasks('grunt-run-grunt');
	grunt.loadNpmTasks('grunt-contrib-handlebars');

	// Task definition
	grunt.registerTask('default', ['install-dependencies', 'run_grunt', 'handlebars', 'less', 'cssmin', 'uglify', 'copy']);
};