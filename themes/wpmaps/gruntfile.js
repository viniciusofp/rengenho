module.exports = function(grunt) {

  grunt.initConfig({
    uglify: {
      options: {
        mangle: false
      },
      angular: {
        files: {
          'js/scripts.js': ['js/angular.min.js', 'js/angular-resource.min.js', 'js/angular-sanitize.min.js', 'js/markerclusterer.js', 'js/rzslider.min.js', 'js/app.js']
        }
      },
      my_target: {
        files: {
          'js/sitescripts.js': ['js/bootstrap.js', 'js/waypoints.js', 'js/inview.js']
        }
      }
    },
    sass: {                              // Task
      dist: {                            // Target
        options: {                       // Target options
          style: 'compressed'
        },
        files: {                         // Dictionary of files
          'style.css': 'style.scss',       // 'destination': 'source'
        }
      }
    },
    watch: {
      css: {
        files: ['style.scss', 'scss/*'],
        tasks: ['sass']
      },
      scripts: {
        files: ['js/app.js'],
        tasks: ['uglify']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['uglify', 'watch']);

};