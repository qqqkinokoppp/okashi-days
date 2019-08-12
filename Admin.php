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
        $sql .= 'UPDATE administrators SET';
        $sql .= 'user_name = :user_name,';
        $sql .= 'password = :password,';
        $sql .= 'name = :name,';
        $sql .= 'email = :email,';
        $sql .= ')';
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
}

?>