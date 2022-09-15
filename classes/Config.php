<?php
    class Config
    {   
        /**
         * ルートディレクトリ
         * 各ソースの先頭でrequire_once(このクラスに対する相対パス）
         * ファイルをrequire_once()する時、Config::APP_ROOT_DIR.パスとする
         */
        // const APP_ROOT_DIR = "C:".DIRECTORY_SEPARATOR."xampp".DIRECTORY_SEPARATOR."htdocs".DIRECTORY_SEPARATOR."okashi_days".DIRECTORY_SEPARATOR;//スラッシュいらない
        // const APP_ROOT_DIR="/home/katachi0501/miraino-katachi.com/public_html/k-shinohara/";
        // const APP_ROOT_DIR="/usr/share/nignx/html/okasi-days/";
        const APP_ROOT_DIR="/Applications/MAMP/htdocs/okashi-days/";

        /**
         * 以下、DB接続用
         *  @var string ユーザー名*/
        // const CONFIG_USER = 'katachi0501_0017';
        const CONFIG_USER = 'root';
    
        /** @var string データベース名、ホスト名、文字コード
         */
        // const CONFIG_DSN = 'mysql:dbname=katachi0501_0017;host=mysql10029.xserver.jp;charset=utf8';
        // const CONFIG_DSN = 'mysql:dbname=okashi_days;host=breadroll.net;charset=utf8';
        const CONFIG_DSN = 'mysql:dbname=okashi_days;host=localhost;charset=utf8';
        
        /**　@var string パスワード 設定なし*/
        // const CONFIG_PASSWORD = 'mirainokatach1';
        // const CONFIG_PASSWORD='';
        const CONFIG_PASSWORD='root';
    }
?>