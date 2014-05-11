//Gruntfile
module.exports = function(grunt) {
	var jqueryUiTheme = 'cupertino';
	// Initializing the configuration object
	grunt.initConfig({
		// Task configuration
		less: {
			development: {
				options: {
					compress: true,  //minifying the result
				},
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
		concat: {
			options: {
				separator: ';',
			},
			development: {
				src: [
				    'bower_components/jquery/dist/jquery.js',
				    'bower_components/jquery-ui/ui/jquery-ui.js',
				    'bower_components/bootstrap/dist/js/bootstrap.js',
				    'bower_components/rickshaw/vendor/d3.min.js',
				    'bower_components/rickshaw/vendor/d3.layout.min.js',
				    'bower_components/rickshaw/rickshaw.js',
				    'assets/js/**/*.js'
	          ],
	          dest: 'public/js/site.js',
	        },
		},
		uglify: {
			options: {
				mangle: false  // Use if you want the names of your functions and variables unchanged
			},
			development: {
				files: [
			        {
						'public/js/site.js': 'public/js/site.js',
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
		phpunit: {
			//not using this yet
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
		        		},
		        ]
			},
		},
		watch: {
			javascript: {
				files: [
				        'assets/js/**/*.js'
		        ],   
		        tasks: ['concat','uglify'], //tasks to run
		        options: {
		        	livereload: false //reloads the browser
	            }
			},
	        less: {
	        	files: [
	        	        'assets/less/**/*.less'
    	        ], //watched files
	        	tasks: ['less', 'cssmin'], //tasks to run
	        	options: {
	        		livereload: false //reloads the browser
	            }
	        },
	        css: {
	        	files: [
	        	        'assets/css/**/*.css'
    	        ], //watched files
	        	tasks: ['less', 'cssmin'], //tasks to run
	        	options: {
	        		livereload: false //reloads the browser
	            }
	        },
		}
	});

	// Plugin loading
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-phpunit');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Task definition
	grunt.registerTask('default', ['concat', 'less', 'cssmin', 'uglify', 'copy']);
};