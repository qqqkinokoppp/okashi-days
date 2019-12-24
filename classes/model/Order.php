<?php
require_once('Base.php');

class Order extends Base
{
    /**
     * 消費税率取得メソッド
     *
     * @param string $date
     * @return double
     */
    public function getTaxrate($date)
    {
        $sql = '';
        $sql .= 'SELECT ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .= 'tax_rate, '; 
        $sql .= 'id '; 
        $sql .= 'FROM tax_rates ';
        $sql .= 'WHERE start_date <= :date ';
        $sql .= 'ORDER BY start_date ';
        $sql .= 'ASC LIMIT 1 ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 送料取得メソッド
     * 会員IDを受け取って、会員テーブル、都道府県テーブル、地域別送料テーブルと結合
     * @param int $id : 会員ID
     * @return array
     */
    public function getDeliveryCharge($id)
    {
        $sql = '';
        $sql .= 'SELECT ';
        $sql .= 'delivery_charge,area_delivery_charge.id AS id ';
        $sql .= 'FROM ';
        $sql .= 'prefectures ';
        $sql .= 'JOIN ';
        $sql .= 'area_delivery_charge ';
        $sql .= 'ON ';
        $sql .= 'prefectures.area_delivery_charge_id = area_delivery_charge.id ';
        $sql .= 'JOIN ';
        $sql .= 'members ';
        $sql .= 'ON ';
        $sql .= 'members.prefecture_id = prefectures.id ';
        $sql .= 'WHERE ';
        $sql .= 'members.id = :id ';

        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 注文登録メソッド
     *
     * @param array $cart
     * @return void
     */
    public function orderRegistration($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO orders ( ';
        $sql .= 'member_id, ';
        $sql .= 'member_last_name, ';
        $sql .= 'member_first_name, ';
        $sql .= 'member_last_name_kana, ';
        $sql .= 'member_first_name_kana, ';
        $sql .= 'postal_code, ';
        $sql .= 'prefecture_id, ';
        $sql .= 'prefecture, ';
        $sql .= 'tax_rate_id, ';
        $sql .= 'delivery_charge_id, ';
        $sql .= 'delivery_charge, ';
        $sql .= 'address1, ';
        $sql .= 'address2, ';
        $sql .= 'phone_number, ';
        $sql .= 'email, ';
        $sql .= 'total ';
        $sql .= ') VALUES (' ;
        $sql .= ':member_id, ';
        $sql .= ':member_last_name, ';
        $sql .= ':member_first_name, ';
        $sql .= ':member_last_name_kana, ';
        $sql .= ':member_first_name_kana, ';
        $sql .= ':postal_code, ';
        $sql .= ':prefecture_id, ';
        $sql .= ':prefecture, ';
        $sql .= ':tax_rate_id, ';
        $sql .= ':delivery_charge_id, ';
        $sql .= ':delivery_charge, ';
        $sql .= ':address1, ';
        $sql .= ':address2, ';
        $sql .= ':phone_number, ';
        $sql .= ':email, ';
        $sql .= ':total ';
        $sql .= ')';

        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':member_id', $data['id'], PDO::PARAM_INT);
        $stmt ->bindValue(':member_last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':member_first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':member_last_name_kana', $data['last_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':member_first_name_kana', $data['first_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':postal_code', $data['postal_code'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture_id', $data['prefecture_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':prefecture', $data['prefecture'], PDO::PARAM_STR);
        $stmt ->bindValue(':tax_rate_id', $data['tax_rate_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':delivery_charge_id', $data['delivery_charge_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':delivery_charge', $data['delivery_charge'], PDO::PARAM_INT);
        $stmt ->bindValue(':address1', $data['address1'], PDO::PARAM_STR);
        $stmt ->bindValue(':address2', $data['address2'], PDO::PARAM_STR);
        $stmt ->bindValue(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt ->bindValue(':total', $data['total'], PDO::PARAM_INT);
        
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 注文詳細登録メソッド
     * @param array $data
     * @param int $order_id
     * @return void
     */
    public function orderDetail($data, $order_id)
    {
        $sql = '';
        $sql .= 'INSERT INTO order_detail ( ';
        $sql .= 'order_id, ';
        $sql .= 'item_id, ';
        $sql .= 'item_name, ';
        $sql .= 'item_model_number, ';
        $sql .= 'quantity, ';
        $sql .= 'subtotal ';
        $sql .= ') VALUES (' ;
        $sql .= ':order_id, ';
        $sql .= ':item_id, ';
        $sql .= ':item_name, ';
        $sql .= ':item_model_number, ';
        $sql .= ':quantity, ';
        $sql .= ':subtotal ';
        $sql .= ')';

        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':order_id', $order_id, PDO::PARAM_INT);
        $stmt ->bindValue(':item_id', $data['id'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_name', $data['item_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_model_number', $data['item_model_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':quantity', $data['quantity'], PDO::PARAM_STR);
        $stmt ->bindValue(':subtotal', $data['subtotal'], PDO::PARAM_STR);
        
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 最新注文ID取得メソッド
     * @return array $rec
     */
    public function getLastOrder()
    {
        $sql = '';
        $sql .= 'SELECT id ';
        $sql .= 'FROM orders ';
        $sql .= 'ORDER BY id ';
        $sql .= 'DESC ';
        $sql .= 'LIMIT 1 ';

        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 会員の購入履歴取得メソッド
     * @param int $id(会員ID)
     */
    public function getMemberOrder($id)
    {
        $sql = 'SELECT ';
        $sql .= 'orders.id AS order_id, ';
        $sql .= 'orders.member_last_name AS last_name, ';
        $sql .= 'orders.member_first_name AS first_name, ';
        $sql .= 'order_date_time, ';
        $sql .= 'total, ';
        $sql .= 'unit_price, ';
        $sql .= 'order_detail.order_id AS order_detail_id, ';
        $sql .= 'order_detail.item_id, ';
        $sql .= 'quantity, ';
        $sql .= 'subtotal, ';
        $sql .= 'items.item_name, ';
        $sql .= 'items.item_image ';
        $sql .= 'FROM orders ';
        $sql .= 'JOIN order_detail ';
        $sql .= 'ON orders.id = order_detail.order_id ';
        $sql .= 'JOIN items ';
        $sql .= 'ON items.id = order_detail.item_id ';
        $sql .= 'WHERE orders.member_id = :id ';
        
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 指定日時での購入履歴取得メソッド
     * @return array $rec
     */
    public function getOrderDate($year, $month, $day)
    {
        $sql = 'SELECT ';
        $sql .= 'orders.id AS order_id, ';
        $sql .= 'orders.order_date_time, ';
        $sql .= 'orders.member_last_name AS last_name, ';
        $sql .= 'orders.member_first_name AS first_name, ';
        $sql .= 'orders.member_last_name_kana AS last_name_kana, ';
        $sql .= 'orders.member_first_name_kana AS first_name_kana, ';
        $sql .= 'orders.member_first_name AS first_name, ';
        $sql .= 'orders.postal_code, ';
        $sql .= 'orders.prefecture, ';
        $sql .= 'orders.address1, ';
        $sql .= 'orders.address2, ';
        $sql .= 'orders.phone_number, ';
        $sql .= 'orders.email, ';
        $sql .= 'orders.delivery_charge, ';
        $sql .= 'orders.total, ';
        // $sql .= 'order_detail.order_id AS order_detail_id, ';
        $sql .= 'order_detail.item_id, ';
        $sql .= 'items.item_name, ';
        $sql .= 'items.unit_price, ';
        $sql .= 'order_detail.quantity, ';
        $sql .= 'order_detail.subtotal ';
        $sql .= 'FROM orders ';
        $sql .= 'JOIN order_detail ';
        $sql .= 'ON orders.id = order_detail.order_id  ';
        $sql .= 'JOIN items ';
        $sql .= 'ON items.id = order_detail.item_id ';
        $sql .= 'WHERE substr(orders.order_date_time,1,4) = :year ';
        $sql .= 'AND substr(orders.order_date_time,6,2) = :month ';
        $sql .= 'AND substr(orders.order_date_time,9,2) = :day ';
        $sql .= 'ORDER BY order_id ';
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':year', $year, PDO::PARAM_STR);
        $stmt ->bindValue(':month', $month, PDO::PARAM_STR);
        $stmt ->bindValue(':day', $day, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }


}
?>