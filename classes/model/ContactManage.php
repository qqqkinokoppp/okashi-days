<?php
require_once('Base.php');

class ContactManage extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * お問い合わせ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addContact($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO contact ( ';
        $sql .= 'name, ';
        $sql .= 'postal_code, ';
        $sql .= 'prefecture,';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'email,';
        $sql .= 'phone_number,';
        $sql .= 'trigger_id,';
        $sql .= 'contact_category_id,';
        $sql .= 'contact_content';
        $sql .= ') VALUES (' ;
        $sql .= ':name, ';
        $sql .= ':postal_code, ';
        $sql .= ':prefecture,';
        $sql .= ':address1,';
        $sql .= ':address2,';
        $sql .= ':email,';
        $sql .= ':phone_number,';
        $sql .= ':trigger_id,';
        $sql .= ':contact_category_id,';
        $sql .= ':contact_content';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt ->bindValue(':postal_code', $data['postal_code'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture', $data['prefecture'], PDO::PARAM_STR);
        $stmt ->bindValue(':address1', $data['address1'], PDO::PARAM_STR);
        $stmt ->bindValue(':address2', $data['address2'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt ->bindValue(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':trigger_id', $data['contact_trigger_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':contact_category_id', $data['contact_category_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':contact_content', $data['contact_content'], PDO::PARAM_STR);

        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お問い合わせ取得メソッド
     * @var int $id
     * @return array $rec 
     */
    public function getContact($id)
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .= 'name, ';
        $sql .= 'postal_code, ';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'email,';
        $sql .= 'phone_number,';
        $sql .= 'trigger_id,';
        $sql .= 'contact_category_id,';
        $sql .= 'contact_content ';
        $sql .='FROM contact ';
        $sql .='JOIN  ';
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id ';
        $sql .='ORDER BY id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * お問い合わせカテゴリ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addContactCategory($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO contact_category ( ';
        $sql .= 'contact_category';
        $sql .= ') VALUES (' ;
        $sql .= ':contact_category';        
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':contact_category', $data['contact_category'], PDO::PARAM_STR);

        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お問い合わせカテゴリ全取得メソッド
     * @return array $rec 
     */
    public function getContactCategoryAll()
    {
        $sql = '';
        $sql .= 'SELECT id, ';
        $sql .= 'contact_category ';
        $sql .= 'FROM contact_category ';
        $sql .= 'WHERE is_deleted=0 ';
        $sql .= 'ORDER BY id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * お問い合わせカテゴリ取得メソッド
     * @param int $id
     * @return array $rec 
     */
    public function getContactCategory($id)
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .= 'contact_category ';
        $sql .='FROM contact_category ';
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id ';
        $sql .= 'ORDER BY id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * お問い合わせカテゴリ修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editContactCategory($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE contact_category SET ';
        $sql .= 'contact_category = :contact_category ';;
        $sql .= 'WHERE id = :id ;';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':contact_category', $data['contact_category'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お問い合わせカテゴリ削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteContactCategory($id)
    {
        $sql ='';
        $sql .='UPDATE contact_category SET ';
        $sql .='is_deleted = 1 ';
        $sql .='WHERE id =:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お問い合わせカテゴリカウントメソッド
     * @var int $id
     * @return bool $rec
     */
    public function countContactCategory($id)
    {
        $sql = '';
        $sql .= 'SELECT COUNT(*) FROM contact WHERE contact_category_id = :contact_category_id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':contact_category_id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * きっかけ全取得メソッド
     * @return array $rec 
     */
    public function getTriggerAll()
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='contact_trigger ';
        $sql .='FROM contact_trigger ';
        $sql .='WHERE is_deleted=0 ';
        $sql .= 'ORDER BY id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * きっかけ取得メソッド
     * @return array $rec 
     */
    public function getTrigger($id)
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='contact_trigger ';
        $sql .='FROM contact_trigger ';
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * きっかけ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addTrigger($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO contact_trigger ( ';
        $sql .= 'contact_trigger';
        $sql .= ') VALUES (' ;
        $sql .= ':contact_trigger';        
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':contact_trigger', $data['contact_trigger'], PDO::PARAM_STR);

        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * きっかけ修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editTrigger($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE contact_trigger SET ';
        $sql .= 'contact_trigger = :contact_trigger ';
        $sql .= 'WHERE id = :id ;';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':contact_trigger', $data['contact_trigger'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * きっかっけ削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteTrigger($id)
    {
        $sql ='';
        $sql .='UPDATE contact_trigger SET ';
        $sql .='is_deleted = 1 ';
        $sql .='WHERE id =:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * きっかけカウントメソッド
     * @var int $id
     * @return bool $rec
     */
    public function countTrigger($id)
    {
        $sql = '';
        $sql .= 'SELECT COUNT(*) FROM contact WHERE trigger_id = :trigger_id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':trigger_id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * お問い合わせ全取得メソッド
     * @return array $rec 
     */
    public function getContactAll()
    {
        $sql = '';
        $sql .= 'SELECT id,';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .= 'name, ';
        $sql .= 'postal_code, ';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'email,';
        $sql .= 'phone_number,';
        $sql .= 'trigger_id,';
        $sql .= 'contact_category_id,';
        $sql .= 'contact_content, ';
        $sql .= 'contact_category, ';
        $sql .= 'contact_trigger ';
        $sql .= 'FROM contact ';
        $sql .= 'JOIN contact_trigger ';
        $sql .= 'ON contact.trigger_id = contact_trigger.id ';
        $sql .= 'JOIN contact_category ';
        $sql .= 'ON contact.contact_category_id = contact_category.id ';
        $sql .= 'WHERE is_deleted=0';
        $sql .= 'ORDER BY id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 日時指定したお問い合わせ全取得メソッド
     * @param string $year
     * @param string $month
     * @param string $day
     * 
     * @return array $rec 
     */
    public function getContactDate($year, $month, $day)
    {
        $sql = '';
        $sql .= 'SELECT contact.id AS contact_id ,';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .= 'contact.create_datetime AS contact_datetime, ';
        $sql .= 'name, ';
        $sql .= 'postal_code,';
        $sql .= 'prefecture,';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'email,';
        $sql .= 'phone_number,';
        $sql .= 'contact_trigger, ';
        $sql .= 'contact_category, ';
        $sql .= 'contact_content ';
        $sql .= 'FROM contact ';
        $sql .= 'JOIN contact_trigger ';
        $sql .= 'ON contact.trigger_id = contact_trigger.id ';
        $sql .= 'JOIN contact_category ';
        $sql .= 'ON contact.contact_category_id = contact_category.id ';
        $sql .= 'WHERE contact.is_deleted=0 ';
        $sql .= 'AND substr(contact.create_datetime,1,4) = :year ';
        $sql .= 'AND substr(contact.create_datetime,6,2) = :month ';
        $sql .= 'AND substr(contact.create_datetime,9,2) = :day ';
        $sql .= 'ORDER BY contact.id ';

        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':year', $year, PDO::PARAM_STR);
        $stmt ->bindValue(':month', $month, PDO::PARAM_STR);
        $stmt ->bindValue(':day', $day, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

}
