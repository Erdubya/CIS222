<?php

class Item
{
    private $itemNum;
    private $item;
    private $price;

    //Sets the name of the item
    public function SetItem($item) {
        $this->item = $item;
    }

    //Sets the item number
    public function SetItemNum($itemNum) {
        $this->itemNum = $itemNum;
    }

    //Sets the item's price
    public function SetPrice($price) {
        $this->price = $price;
    }
    
    //Returns the item name
    public function GetItem() {
        return $this->item;
    }
    
    //Returns the item number
    public function GetItemNum() {
        return $this->itemNum;
    }
    
    //Returns the price of the item
    public function GetPrice() {
        return $this->price;
    }
}
