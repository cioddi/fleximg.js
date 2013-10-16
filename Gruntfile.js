module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    copy: {
      main: {
        files: [
          {expand: true, src: ['lib/**'], dest: 'dist/', filter: 'isFile'},
          {expand: true, src: ['img','img/fleximg_scale'], dest: 'dist/'},
          {expand: true, src: ['README.md','.htaccess','bower.json','LICENSE.md','scale.php','testconfiguration.php'], dest: 'dist/'}, // makes all src relative to cwd
        ]
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      dist: {
        files: {
          'dist/<%= pkg.name %>.min.js': ['scale.js']
        }
      }
    },
    jshint: {
      files: ['Gruntfile.js', 'scale.js']
    },
    compress: {
      main: {
        options: {
          archive: 'build/fleximg.zip'
        },
        files: [
          {expand: true, cwd: 'dist/', src: ['**']}
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-compress');

  grunt.registerTask('test', ['jshint']);

  grunt.registerTask('zip', ['compress']);

  grunt.registerTask('build', ['jshint','uglify','copy','compress']);

  grunt.registerTask('default', ['jshint']);

};