<?php

class Item
{
    private $itemNum;
    private $item;
    private $price;

    public function SetItem($item) {
        $this->item = $item;
    }

    public function SetItemNum($itemNum) {
        $this->itemNum = $itemNum;
    }

    public function SetPrice($price) {
        $this->price = $price;
    }
    
    public function GetItem() {
        return $this->item;
    }
    
    public function GetItemNum() {
        return $this->itemNum;
    }
    
    public function GetPrice() {
        return $this->price;
    }
}
