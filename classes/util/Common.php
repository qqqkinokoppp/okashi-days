<?php
class Common
{
    /**
     * フォームからPOSTされたデータのサニタイズ
     * @var array $post
     * @return array $after
     */
    public function sanitize($post)
    {
        $after = array();
        foreach($post as $key => $value)
        {
            $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $after;
    }
}
?>