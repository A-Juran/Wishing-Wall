<?php

namespace app\index\model;

use think\Model;
use think\Db;

class IndexModel extends Model
{
    //查看所有卡片
    public function w_select($page)
    {
        $page = (($page-1)*16);
        $result = Db::query("select `w_id`,`w_Name`,`w_Content`,`w_Time`,`w_Color` from wish_love order by w_id desc limit $page,16 ");

        if ($result) {
            return json_encode($result);
        }
        return 0;
    }
    //新增卡片信息
    public function w_insert($name, $content, $password, $color, $time)
    {
        $data = ['w_Name' => "$name", 'w_Content' => "$content", 'w_Password' => "$password", 'w_Color' => "$color", 'w_Time' => "$time"];
        // $sql = "INSERT INTO wish_love VALUES  (w_Name = `$name`,w_Content = `$contant`, = ``,w_Time = ``)";
        $result = Db::table('wish_love')->insert($data);

        return (int)$result;
    }
    //删除卡片信息
    public function w_delete($id)
    {
        $result = Db::table('wish_love')->where('w_id', $id)->delete();

        return (int)$result;
    }
    //查看卡片信息
    public function w_retrieve($id, $password)
    {
        // $result = Db::table('wish_love')->where('w_password',$password)->find();
        $result = Db::table('wish_love')->where(['w_id' => "$id", 'w_password' => "$password"])->field('w_id,w_Name,w_content,w_Time')->find();


        return json_encode($result);
    }
    //修改卡片信息
    public function w_update($id, $name, $content, $color)
    {

        $data = ['w_Content' => "$content", 'w_Color' => "$color"];

        $result = Db::table('wish_love')->where(['w_id' => "$id", 'w_Name' => "$name"])->update($data);

        return $result;
    }
}
