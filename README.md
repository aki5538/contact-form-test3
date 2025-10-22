# Contact-form-test3(お問い合わせ管理アプリ)

## 環境構築手順

リポジトリをclone
```
git clone git@github.com:aki5538/contact-form-test.git
cd contact-form-test3
```

Dockerを起動
```
docker compose up -d --build
```

envファイルの準備
```
cp src/.env.example src/.env
```
※ Laravel本体はsrcディレクトリ内にあります。


envファイルの修正

作成ができたら、以下のように修正してください。
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

Laravelのセットアップ
```
docker-compose exec php bash
cd src
composer install
php artisan migrate
php artisan key:generate
```

初期データの投入
```
php artisan db:seed
```

## 使用技術(実行環境)
- PHP 8.1
- Laravel 8.75
- MySQL 8.0

## ER図
![alt](docs/erd.png)

## 動作URL

- 開発環境 : http://localhost/
- phpMyAdmin : http://localhost:8080/
