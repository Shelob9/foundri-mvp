module.exports = function (grunt) {

    grunt.initConfig( {
        shell: {
            composer: {
                command:
                    'cd foundri-mvp-content/plugins; pwd; ls; cd cf-users; pwd; composer update; cd ../; cd ../; cd mu-plugins; cd lib; pwd; composer update;'
            }
        }
    } );

    grunt.loadNpmTasks( 'grunt-shell' );


    grunt.registerTask( 'composer-plugins',
        'shell:composer'
    );


};
