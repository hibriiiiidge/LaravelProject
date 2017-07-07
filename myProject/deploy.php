<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuration
set('repository', 'git@github.com:hibriiiiidge/LaravelProject.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);


// Hosts
host('13.114.47.97')
    ->user('ubuntu')
    ->port(22)
    ->identityFile('~/.ssh/master.pem')
    ->stage('production')
    ->set('deploy_path', '/var/www/html');

// Tasks
desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// task('deploy:migrate', function(){
//   run('{{bin/php}} /var/www/html/releases/1/myProject/artisan migrate --force');
// });
set('release_path', '/var/www/html/releases/myProject');

task('deploy:migrate', function () {
run('{{bin/php}} {{release_path}}/artisan migrate --force');
//run('var_dump({{release_path}})');
});


// Migrate database before symlink new release.
before('deploy:symlink', 'deploy:migrate');
//before('deploy:symlink', 'artisan:migrate');

task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);
