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

task('deploy:migrate', function(){
  run('{{bin/php}} /var/www/html/releases/1/myProject/artisan migrate --force');
});

// task('deploy:migrate', function () {
// run('{{bin/php}} {{release_path}}/artisan migrate --force');
// });


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


// require 'recipe/laravel.php';
//
// // デフォルトがUTCなので上書き
// env('timezone', 'Asia/Tokyo');
//
// // デプロイ先のサーバ情報を定義
// //serverList('config/server.yml');
// server('myProject', '13.114.47.97', 22)
//     ->user('ubuntu')
//     // ssh agentを使い認証します。
//     ->forwardAgent()
//     ->stage('production')
//     // デプロイ先のベースパスを定義します。
//     ->env('deploy_path', '/var/www/html/');
//
// // デプロイしたプロジェクトを直近5件保存しておく (デフォルトは3件)
// // -> 保存しておいた分だけrollbackコマンドを使用できる
// set('keep_releases', 5);
//
// // デプロイするリポジトリのURL
// set('repository', 'git@github.com:hibriiiiidge/LaravelProject.git');
//
// // shared_dirsを上書き (deploy:sharedで使用)
// // -> 対象ディレクトリがなければ作ってくれる
// set('shared_dirs', [
//     'storage/app',
//     'storage/framework/cache',
//     'storage/framework/sessions',
//     'storage/framework/views',
//     'storage/logs',
// ]);
//
// // shared_filesを上書き (deploy:sharedで使用)
// // -> 対象ファイルがなければ空ファイルを作ってくれる
// // -> sqliteを使う場合、ここで設定しておくと良さそう(?)
// set('shared_files', [
//     '.env',
//     // 'database/database.sqlite',
// ]);
//
// // writable_dirsを上書き (deploy:writableで使用)
// // -> デプロイ先の環境によってパーミッションの変更方法が変わる
// set('writable_dirs', [
//     'bootstrap/cache',
//     'storage/app',
//     'storage/framework/cache',
//     'storage/framework/sessions',
//     'storage/framework/views',
//     'storage/logs',
// ]);
