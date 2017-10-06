module.exports = function(grunt) {
    // Path to our JavaScript source files
    var jssrc = ['jslib/*.js'];

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            js: {
                src: jssrc,
                dest: 'site.min.js'
            }
        },

        concat: {
            options: {
                banner: '/*! DO NOT EDIT <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            js: {
                src: jssrc,
                dest: 'site.con.js'
            }
        }

    });

    // Load the plugins for the tasks
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');

    // Default task(s).
    grunt.registerTask('default', ['concat:js', 'uglify:js']);

};