<?php 
// require_once('C:\xampp\htdocs\okashi_days\classes\Config.php');
// require_once('/home/katachi0501/miraino-katachi.com/public_html/k-shinohara/classes/Config.php');
require_once("/Applications/MAMP/htdocs/okashi-days/classes/Config.php");

class Base//DB接続の基底クラス
{   
    /** @var string ユーザー名*/
    protected const USER = Config::CONFIG_USER;
    
    /** @var string データベース名、ホスト名、文字コード
     */
    protected const DSN = Config::CONFIG_DSN;
    
    /**　@var string パスワード 設定なし*/
    protected const PASSWORD = Config::CONFIG_PASSWORD;

    /** @var object データベースハンドル　PDOインスタンス */
    protected $dbh;
    
    /**　コンストラクタ */
    public function __construct()
    {   
        // print '接続';
        $this ->dbh = new PDO(self::DSN, self::USER, self::PASSWORD);
        //DB接続において例外発生時、PDOExceptionが投げられる
        $this ->dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // print '接続成功';
    }
    
    /** 
     * 以下、トランザクション関係
     * トランザクション開始メソッド */
    public function begin()
    {
        $this ->dbh ->beginTransaction();
    }

    /**ロールバックメソッド */
    public function rollBack()
    {
        $this ->dbh ->rollBack();
    }
    
    /**コミットメソッド */
    public function commit()
    {
        $this ->dbh ->commit();
    }
}
?>