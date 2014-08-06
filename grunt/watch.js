module.exports = {
    javascript: {
        files: [
            'app/**/*.js'
        ],
        tasks: ['newer:uglify']
    },
    less: {
        files: [
            'app/**/*.less'
        ], //watched files
        tasks: ['less', 'cssmin']
    },
    css: {
        files: [
            'app/**/*.css'
        ], //watched files
        tasks: ['less', 'cssmin']
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