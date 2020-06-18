module.exports = function (grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        banner: '/*!\n' +
            ' * jQuery Form Validation\n' +
            ' * Copyright (C) 2015 RunningCoder.org\n' +
            ' * Licensed under the MIT license\n' +
            ' *\n' +
            ' * @author <%= pkg.author.name %>\n' +
            ' * @version <%= pkg.version %> (<%= grunt.template.today("yyyy-mm-dd") %>)\n' +
            ' * @link http://www.runningcoder.org/jqueryvalidation/\n' +
            '*/\n',

        clean: {
            dist: ["dist"]
        },

        copy: {
            dist: {
                files: [
                    {
                        src: ['src/jquery.validation.js'],
                        dest: 'dist/jquery.validation.js'
                    },
                    {
                        src: ['src/jquery.validation.js'],
                        dest: 'dist/jquery.validation.min.js'
                    }
                ]
            }
        },

        comments: {
            dist: {
                options: {
                    singleline: true,
                    multiline: true
                },
                src: [ 'dist/jquery.validation.js']
            }
        },

        replace: {
            banner: {
                options: {
                    patterns: [
                        {
                            match: /\/\*![\S\s]+?\*\/[\r\n]*/,
                            replacement: '<%= banner %>'
                        }
                    ]
                },
                files: [
                    {
                        src: ['src/jquery.validation.js'],
                        dest: 'src/jquery.validation.js'
                    }
                ]
            },
            removeDebug: {
                options: {
                    patterns: [
                        {
                            match: /\/\/\s?\{debug}[\s\S]*?\{\/debug}/g,
                            replacement: ''
                        }
                    ]
                },
                files: [
                    {
                        src: ['dist/jquery.validation.min.js'],
                        dest: 'dist/jquery.validation.min.js'
                    }
                ]
            },
            removeComments: {
                options: {
                    patterns: [
                        {
                            match: /\/\*[^!][\S\s]+?\*\//gm,
                            replacement: ''
                        }
                    ]
                },
                files: [
                    {
                        src: ['dist/jquery.validation.js'],
                        dest: 'dist/jquery.validation.js'
                    }
                ]
            }
        },

        jsbeautifier : {
            files : ['dist/jquery.validation.js'],
            options : {
            }
        },

        uglify: {
            dist: {
                options: {
                    mangle: true,
                    compress: true,
                    banner: '<%= banner %>'
                },
                files: {
                    'dist/jquery.validation.min.js': ['dist/jquery.validation.min.js']
                }
            }

        }

    });

    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-stripcomments');
    grunt.loadNpmTasks('grunt-replace');
    grunt.loadNpmTasks("grunt-jsbeautifier");
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', [
        'clean:dist',
        'replace:banner',
        'copy:dist',
        'comments',
        'replace:removeComments',
        'jsbeautifier',
        'replace:removeDebug',
        'uglify'
    ]);

};
