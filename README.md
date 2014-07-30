mandelbrot-demo
===============

マンデルブロ集合の描画 (第 80 回 PHP 勉強会で LT を行ったときのデモプログラム)

実行方法
--------

### PHP

普通に httpd と php を導入して設定すればよいです。

### HHVM

HHVM を daemon として起動します。

    # hhvm --mode daemon -vServer.Type=fastcgi -vServer.Port=9000

httpd の設定ファイルを作成します。
勉強会では、PHP と比較できるように、8080 番ポートを hhvm に送りました。

    Listen 8080
    <VirtualHost *:8080>
      DocumentRoot /var/www/html
      ProxyPassMatch ^/(.*\.(hh|php)(/.*)?)$ fcgi://127.0.0.1:9000/var/www/html/$1
    </VirtualHost>

HHVM で高速に実行するための tips
--------------------------------

LT ではコードの内容には触れませんでしたが、HHVM の JIT compiler の恩恵を受けるためにはいくつかコツがあります。
(以下は一例です。ほかにもいろいろあるかもしれません)

### 処理を関数化する

JIT compiler は関数単位で処理します。グローバルスコープにベタ書きされた処理は対象になりません。

### リクエストパラメータ等は正しい型にキャストして使う

JIT compiler による最適化は型情報を利用するようです。正しい型にキャストすることで、高速に動作するようになります。

その他
------

一定の頻度で実行される関数が JIT compile の対象になるようです。JIT compile されるまでは HHVM で実行しても遅いです。
