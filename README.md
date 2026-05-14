# Items-Management-Laravel

## 概要

備品管理のバックエンドリポジトリ
（APIでのCRUD操作など学習用）

## コマンド集（TBD）

- サーバー起動

    ```shell
    $ php artisan serve
    ```

- マイグレーション

    ```shell
    $ php artisan migrate
    ```

- マイグレーション（データ削除→Seedデータ作成）

    ```shell
    $ php artisan migrate:fresh --seed
    ```

- 認証ルート確認

    ```shell
    $ php artisan route:list -v
    ```

- テスト（特定）
    ```shell
    $ php artisan test --filter={ItemApiTest}
    ```
