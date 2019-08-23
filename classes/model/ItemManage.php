<?php
class ItemManage extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * カテゴリ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addCategory($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO item_categories (';
        $sql .= 'item_category_name,';
        $sql .= 'item_category_image';
        $sql .= ') VALUES (';
        $sql .= ':item_category_name,';
        $sql .= ':item_category_image';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':item_category_name', $data['item_category_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_category_image', $data['item_category_image'], PDO::PARAM_STR);
        $rec = $stmt ->execute();
        return $rec;
    }
    /**
     * カテゴリ修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editCategory($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE item_categories SET';
        $sql .= 'item_category_name = :item_category_name,';
        $sql .= 'item_category_image = :item_category_image';
        $sql .= ')';
        $sql .= 'WHERE id = :id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':item_category_name', $data['item_category_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_category_image', $data['item_category_image'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }
    /**
     * カテゴリ削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteCategory($id)
    {
        $sql ='';
        $sql .='UPDATE item_categories SET';
        $sql .='is_deleted = 1';
        $sql .='WHERE id =:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }
    /**
     * 商品詳細登録メソッド
     * @var array $data
     * @return bool $rec
     */
    public function addItemDetail($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO items (';
        $sql .= 'item_category_id,';
        $sql .= 'item_name,';
        $sql .= 'item_model_number,';
        $sql .= 'item_description';
        $sql .= 'allergy_item,';
        $sql .= 'item_detail,';
        $sql .= 'unit_price';
        $sql .= 'item_image';
        $sql .= 'is_recomend';
        $sql .= ') VALUES (';
        $sql .= ':item_category_id,';
        $sql .= ':item_name,';
        $sql .= ':item_model_number,';
        $sql .= ':item_description';
        $sql .= ':allergy_item,';
        $sql .= ':item_detail,';
        $sql .= ':unit_price,';
        $sql .= ':item_image,';
        $sql .= ':is_recomend';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':item_category_id', $data['item_category_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_name', $data['item_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_model_number', $data['item_model_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_description', $data['item_description'], PDO::PARAM_STR);
        $stmt ->bindValue(':allergy_item', $data['allergy_item'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_detail', $data['item_detail'], PDO::PARAM_STR);
        $stmt ->bindValue(':unit_price', $data['unit_price'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_image', $data['item_image'], PDO::PARAM_STR);
        $stmt ->bindValue(':is_recommend', $data['is_recommend'], PDO::PARAM_STR);
        $rec = $stmt ->execute();
        return $rec;
    }
    /**
     * 商品詳細修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editItemDetail($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE items SET';
        $sql .= 'item_category_id = :item_category_id,';
        $sql .= 'item_name = :item_name,';
        $sql .= 'item_model_number = :item_model_number,';
        $sql .= 'item_description = :item_description';
        $sql .= 'allergy_item = :allergy_item,';
        $sql .= 'item_detail = :item_detail,';
        $sql .= 'unit_price = :unit_price';
        $sql .= 'item_image = :item_image';
        $sql .= 'is_recomend = :is_recomend';
        $sql .= 'WHERE id = :id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':item_category_id', $data['item_category_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_name', $data['item_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_model_number', $data['item_model_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_description', $data['item_description'], PDO::PARAM_STR);
        $stmt ->bindValue(':allergy_item', $data['allergy_item'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_detail', $data['item_detail'], PDO::PARAM_STR);
        $stmt ->bindValue(':unit_price', $data['unit_price'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_image', $data['item_image'], PDO::PARAM_STR);
        $stmt ->bindValue(':is_recomend', $data['is_recomend'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }
    /**
     * 商品詳細削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteItemDetail($id)
    {
        $sql ='';
        $sql .='UPDATE items SET';
        $sql .='is_deleted = 1';
        $sql .='WHERE id =:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }
}
?>