<?php

require 'recipe/laravel.php';

// デフォルトがUTCなので上書き
env('timezone', 'Asia/Tokyo');

// デプロイ先のサーバ情報を定義
//serverList('config/server.yml');

// デプロイしたプロジェクトを直近5件保存しておく (デフォルトは3件)
// -> 保存しておいた分だけrollbackコマンドを使用できる
set('keep_releases', 5);

// デプロイするリポジトリのURL
set('repository', 'https://github.com/hibriiiiidge/LaravelProject.git');

// shared_dirsを上書き (deploy:sharedで使用)
// -> 対象ディレクトリがなければ作ってくれる
set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// shared_filesを上書き (deploy:sharedで使用)
// -> 対象ファイルがなければ空ファイルを作ってくれる
// -> sqliteを使う場合、ここで設定しておくと良さそう(?)
set('shared_files', [
    '.env',
    // 'database/database.sqlite',
]);

// writable_dirsを上書き (deploy:writableで使用)
// -> デプロイ先の環境によってパーミッションの変更方法が変わる
set('writable_dirs', [
    'bootstrap/cache',
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

server('myProject', '13.114.47.97', 22)
    ->user('ubuntu')
    // ssh agentを使い認証します。
    ->forwardAgent()
    ->stage('production')
    // デプロイ先のベースパスを定義します。
    ->env('deploy_path', '/var/www/html/');
