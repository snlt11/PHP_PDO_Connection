<?php
require_once('DBGen.php');
class DAL
{
    private $db;

    public function __construct(){
        $this->db = DBGen::getInstance()->getConn();
    }
    public function getSingleShop($id){
        $stmt = $this->db->prepare("SELECT * FROM shops WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->bindParam('name',$name);
        $stmt->bindParam('ipadd',$ipadd);
        $result = $stmt->fetchObject();

        echo $result->name ."<br>". $result->ipadd . $result->username;
    }
    public function getAllShops($state)
    {
        $stmt = $this->db->prepare("SELECT * FROM shops WHERE state= :state");
        $stmt->bindParam(':state', $state);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $item){
            echo $item['name']."<br>";
            echo $item['ipadd']."<br>";
            echo $item['created_at']."<br>";

    }
//        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
//        foreach($result as $item){
//            echo $item->name ."<br>";
//            echo $item->ipadd ."<br>";
//        }
    }
    public function singleShopInsert($name,$ipadd,$username,$password,$state){

        $addDatetime = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO shops(name,ipadd,username,password,state,created_at) VALUES(:name,:ipadd,:username,:password,:state,:created_at)");
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':ipadd',$ipadd);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':state',$state);
        $stmt->bindParam(':created_at',$addDatetime);

        $result = $stmt->execute();
        $insertId = $this->db->lastInsertId();

        echo $result ? "DataInsert Successfully" . $insertId : "DataInsert Failure";

    }
    public function insertMultipleShops($shops){
        $addDate = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO shops (name,ipadd,username,password,state,created_at) VALUES (:name,:ipadd,:username,:password,:state,:created_at)");

        foreach ($shops as $shop){
            $stmt->bindParam(':name',$shop['0']);
            $stmt->bindParam(':ipadd',$shop['1']);
            $stmt->bindParam(':username',$shop['2']);
            $stmt->bindParam(':password',$shop['3']);
            $stmt->bindParam(':state',$shop['4']);
            $stmt->bindParam(':created_at',$addDate);
            $result = $stmt->execute();
            $lastId = $this->db->lastInsertId();
            echo $result ? "Insert successful "  . $lastId . "<br>": "Insert Failed";
        }
    }
    public function updateShop($id,$name,$password){
        $statement = $this->db->prepare("UPDATE shops SET name = :name, password = :password WHERE id = :id");
        $statement->bindParam(':id',$id);
        $statement->bindParam(':name',$name);
        $statement->bindParam(':password',$password);
        $result = $statement->execute();

        echo $result ? "Update Successful" : "Update Failure";

    }
    public function deleteShop($id){
        $statement = $this->db->prepare("DELETE FROM shops WHERE id = :id");
        $statement->bindParam(':id',$id);
        $result = $statement->execute();
        echo $result ? "Delete Success" : "Delete Failure";
    }
    public function joinData($shopid){
        $statement = $this->db->prepare("
            SELECT
                sh.name AS name,
                sh.created_at AS created_at,
                SUM(od.price * od.amount) AS total
            FROM
                shops AS sh
            LEFT JOIN
                orders AS od
            ON od.shopid = sh.id
            WHERE sh.id = :id AND sh.state = 1
        ");
        $statement->bindParam(':id',$shopid);
        $statement->execute();
        $statement->bindColumn('name',$name);
        $statement->bindColumn('created_at',$created_at);
        $statement->bindColumn('total',$total);
        $result = $statement->fetchObject();

        echo $result->name ."<br/>";
        echo $result->created_at ."<br/>";
        echo $result->total ."<br/>";
    }



}