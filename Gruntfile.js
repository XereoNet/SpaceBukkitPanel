module.exports = function(grunt) {
  grunt.initConfig({
    uglify: {
      default: {
        expand: true,
        cwd: 'app/webroot/sources',
        src: ['**/*.js'],
        dest: '.tmp/app/webroot',
        /* Workaround for Grunt's default behaviour with periods in filenames. Ugh! */
        rename: function (dest, src) { return dest + '/' + src.replace('.', '___'); }
      }
    },
    cssmin: {
      default: {
        expand: true,
        cwd: 'app/webroot/sources',
        src: ['**/*.css'],
        dest: '.tmp/app/webroot',
        /* Workaround for Grunt's default behaviour with periods in filenames. Ugh! */
        rename: function (dest, src) { return dest + '/' + src.replace('.', '___'); }
      }
    },
    copy: {
      misc: {
        expand: true,
        cwd: 'app/webroot/sources',
        src: ['**/*.png', '**/*.gif', '**/*.jpg', '**/*.xml'],
        dest: 'app/webroot',
      },
      assets: {
        expand: true,
        cwd: '.tmp/app/webroot',
        src: ['**/*'],
        dest: 'app/webroot',
        rename: function (dest, src) { return dest + '/' + src.replace('___', '.'); }
      }
    },
    clean: ['.tmp']
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');

  grunt.registerTask('default', ['uglify', 'cssmin', 'copy', 'clean']);

};