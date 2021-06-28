<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\IndexModel;
use think\Db;

class Index extends Controller
{
  public function index(){
    return "this is wishing——wall";
  }
  //查看所有卡片信息
  public function w_select()
  {
    //查找页数
    $page = trim(Request::instance()->param("pages"));
    //获取数据的总数量
    $count= Db::name('wish_love')->count();

    $info = new IndexModel();

    $result = $info->w_select($page);
    
    $arrary=htmlspecialchars_decode($result);
    $arrarylist=html_entity_decode($arrary);

    $w_data = array(
      'code' => "200",
      'msg' => "查询成功",
      'total_num' => $count,
      'data' => json_decode($arrarylist,true)
    );

    return json_encode($w_data);
  }
  //新增卡片信息
  public function w_insert()
  {
    //卡片用户名
    $name = trim(Request::instance()->param("name"));
    //卡片文章
    $content = trim(Request::instance()->param("content"));
    //卡片颜色
    $color = trim(Request::instance()->param("color"));
    //卡片密码
    $password = trim(Request::instance()->param("password"));
    //许愿时间
    $time = date("Y-m-d H:i:s");

    $info = new IndexModel();

    if (!$name) {
      return json_encode(['code' => '500', 'msg' => '请留下你的署名噢']);
    }
    if (!$content) {
      return json_encode(['code' => '500', 'msg' => '你还未许愿呢?']);
    }
    if (!$password) {
      return json_encode(['code' => '500', 'msg' => '嘿嘿! 不设置密码怎么背着我修改愿望啊']);
    }

    $result = $info->w_insert($name, $content, $password,$color,$time); //提交请求

    if ($result) {
      return json_encode(['code' => '200', 'msg' => '添加成功,希望你一如既往！']);
    }
    return json_encode(['code' => '500', 'msg' => '代码没写好，不关你的事！']);
  }
  //删除卡片信息
  public function w_delete()
  {
    //获取id
    $id = trim(Request::instance()->param("id")); //卡片用户名

    $info = new IndexModel();

    $result = $info->w_delete($id);

    if ($result) {
      return json_encode(['code' => '200', 'msg' => '删除成功了,但是你在淦！什么啊！！']);
    }
    return json_encode(['code' => '500', 'msg' => '代码没写好，不关你的事！']);
  }
  //查看卡片信息
  public function w_retrieve()
  {
    //卡片id
    $id = trim(Request::instance()->param("id"));
    //卡片密码
    $password = trim(Request::instance()->param("password"));

    $info = new IndexModel();

    $result = $info->w_retrieve($id,$password);
    
    return $result;

    $arrary=htmlspecialchars_decode($result);
    $arrarylist=html_entity_decode($arrary);

    if ($result) {
      $w_data = [
        'code' => "200",
        'msg' => "查询成功",
        'data' => json_decode($arrarylist,true)
      ];
      return json_encode($w_data);
    }
    return json_encode(['code' => '500', 'msg' => '代码没写好，不关你的事！']);
  }
  //修改卡片信息
  public function w_update()
  {
    //卡片id
    $id = Request::instance()->param("id");
    //卡片用户名
    $name = trim(Request::instance()->param("name"));
    //卡片文章
    $content = trim(Request::instance()->param("content"));
    //卡片颜色
    $color = trim(Request::instance()->param("color"));

    $info = new IndexModel();

    $result = $info->w_update($id, $name, $content,$color);

    if ($result) {
      return json_encode(['code' => '200', 'msg' => '修改成功,目标达不到了么？']);
    }
    return json_encode(['code' => '500', 'msg' => '代码没写好，不关你的事！']);
  }
}
