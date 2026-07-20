# お天気アプリ（バックエンドAPI）

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

お天気アプリのデータ管理およびフロントエンドへデータを提供するREST APIサーバーです。
Dockerコンテナ上で動作し、地域の保存や重複チェックロジックを処理します。

## 機能一覧

- お気に入り・履歴場所の保存機能 (`POST /api/locations`)
- 保存済み地域一覧の取得機能 (`GET /api/locations`)
- `firstOrCreate` を用いた同じ地名の重複登録防止機能
- 緯度 (latitude) / 経度 (longitude) のデータベース保持機能
- リクエストバリデーションによるデータ品質担保

本プロジェクトはDockerコンテナ上で動作します。

## 環境構築

```bash
git clone https://github.com/orangecraftsparkling-3280/weather-app-backend.git
cd weather-app-backend

cp .env.example .env

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

echo "Waiting for MySQL to boot up..."
sleep 15

./vendor/bin/sail artisan migrate:fresh --seed
```

## 実行環境

- Docker環境
- PHP 8.x
- Laravel 10.x / 11.x
- MySQL 8.0
- Docker Sail環境

## ホストOS

- macOS / Windows / Linux（Dockerが動作する環境）

## 推奨ブラウザ

- Chrome / Firefox / Edge（最新バージョン）

## 接続先一覧

- バックエンドAPIベースURL: http://localhost:8000

## 🛠 データベース設計

> 各テーブル名をクリックすると、詳細なカラム構成を確認できます。
> <br>

<details>
<summary> 📘 <code>locations</code></summary>
<br>

| カラム名         | 型              | PK  | UK  | NN  | 備考              |
| :--------------- | :-------------- | :-: | :-: | :-: | :---------------- |
| **id**           | unsigned bigint |  ○  |     |  ○  |                   |
| **city_name**    | string          |     |     |  ○  | 登録された地名    |
| **country_code** | string          |     |     |  ○  | 国コード (例: JP) |
| **latitude**     | double          |     |     |  ○  | 緯度              |
| **longitude**    | double          |     |     |  ○  | 経度              |
| **created_at**   | timestamp       |     |     |     |                   |
| **updated_at**   | timestamp       |     |     |     |                   |

</details>

## 作成者

- 作成者: [kazuyuki asari]
- GitHub: https://github.com/orangecraftsparkling-3280
