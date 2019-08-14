<?php
require_once('Base.php');

class Admin extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 管理者登録メソッド
     * @var array $data：管理者登録に必要な項目の連想配列
     * @return bool $rec
     */
    public function addAdmin($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO administrators (';
        $sql .= 'user_name,';
        $sql .= 'password,';
        $sql .= 'name,';
        $sql .= 'email';
        $sql .= ') VALUES (';
        $sql .= ':user_name,';
        $sql .= ':password,';
        $sql .= ':name,';
        $sql .= ':email';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt ->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);

        $rec = $stmt ->execute();

        return $rec;
    }

    /**
     * 管理者修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editAdmin($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE administrators SET ';
        $sql .= 'user_name = :user_name,';
        $sql .= 'password = :password,';
        $sql .= 'name = :name,';
        $sql .= 'email = :email';
        $sql .= 'WHERE id = :id';

        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt ->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);

        $rec = $stmt ->execute();

        return $rec;
    
    }

    /**
     * 管理者削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id:管理者ID
     * @return bool $rec
     */
    public function deleteAdmin($id)
    {
        $sql ='';
        $sql .='UPDATE administrators SET';
        $sql .='is_deleted = 1';
        $sql .='WHERE id =:id';

        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);

        $rec = $stmt ->execute();

        return $rec;
    }

    /**
     * 管理者ログインメソッド
     * 入力されたパスワードが、ユーザー名に相当するパスワードと一致するか調べる
     * @var str $user_name
     * @var str $password
     * @return array  ログイン成功時以外は空配列を返す
     */
    public function loginAdmin($user_name, $password)
    {
        //パスワード、ユーザー名が入力されていなければ空配列を返す
        if(!isset($user_name)||!isset($password))
        {
            return array();
        }

        $sql = '';
        $sql .='SELECT password FROM administrators';
        $sql .='WHERE user_name = :user_name';

        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':user_name', $user_name, PDO::PARAM_STR);

        $stmt ->execute();

        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        
        //ユーザー名に相当するパスワードが登録されていなければ空配列を返す
        if(!isset($rec['password']))
        {
            return array();
        }

        //DBに登録されているパスワードと入力されたパスワードが一致しなければ空配列を返す
        if(!password_verify($password, $rec['password']))
        {
            return false;
        }

        return $rec;
    }
}

?>