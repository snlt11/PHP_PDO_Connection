<?php
include_once ('Database/DAL.php');


class index{

    public function __construct(){
        $dal = new DAL();
//        $dal->updateShop(4,"Pocari Sweat",'098767');
//            $shops = [
//            ["OnePlus","127.0.0.1","onePlus","12455","1"],
//            ["Book","127.0.0.2","book","12455","1"],
//            ["Phone","127.0.0.3","phone","12455","1"],
//            ["Pocari","127.0.0.4","pocari","12455","1"],
//        ];

        $dal->joinData(1);

    }


}
new index();






