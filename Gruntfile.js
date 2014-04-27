//Gruntfile
module.exports = function(grunt) {

	// Initializing the configuration object
	grunt.initConfig({
		// Task configuration
		concat: {
			options: {
				separator: ';',
			},
			development: {
				src: [
				      'bower_components/jquery/dist/jquery.js',
				      'bower_components/bootstrap/dist/js/bootstrap.js',
				      'assets/js/**/*.js'
	          ],
	          dest: 'public/js/site.js',
	        },
		},
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
		uglify: {
			options: {
				mangle: false  // Use if you want the names of your functions and variables unchanged
			},
			development: {
				files: {
					'public/js/site.js': 'public/js/site.js',
				}
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
	        	tasks: ['less'], //tasks to run
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

	// Task definition
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('setup', ['concat', 'less', 'uglify', 'copy']);
};