<?php

/**
 * Class Item<br>
 * Represents a single item in the order array.
 * Includes setters and getters for all data.
 * Data is not changed within the class.
 */
class Item
{
    private $itemNum;
    private $item;
    private $price;

    /**
     * Sets the name of the item
     * @param $item string The name of the item
     */
    public function SetItem($item) {
        $this->item = $item;
    }

    /**
     * Sets the item number
     * @param $itemNum int The item number (without check digit)
     */
    public function SetItemNum($itemNum) {
        $this->itemNum = $itemNum;
    }

    /**
     * Sets the item's price
     * @param $price float The current price of the item
     */
    public function SetPrice($price) {
        $this->price = $price;
    }

    /**
     * Returns the item name
     * @return string The name of the item
     */
    public function GetItem() {
        return $this->item;
    }

    /**
     * Returns the item number
     * @return int The item number
     */
    public function GetItemNum() {
        return $this->itemNum;
    }

    /**
     * Returns the price of the item
     * @return float The price of the item when stored
     */
    public function GetPrice() {
        return $this->price;
    }
}
