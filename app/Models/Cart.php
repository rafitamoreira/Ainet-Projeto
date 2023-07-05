<?php

namespace App\Models;

class Cart
{
    public $items = null;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
        }
    }

    public function add($item, $id, $qty, $tamanho, $cor)
    {
        $preco = Preco::find(1);
        if ($item->customer_id == null) {
            $price = $preco->unit_price_catalog;
        } else {
            $price = $preco->unit_price_own;
        }

        $storedItem = ['id' => 0, 'qty' => 0, 'price' => $price, 'item' => $item, 'tamanho' => $tamanho, 'cor' => $cor];
        $itemIndex = 0;
        if ($this->items) {
            $itemIndex = count($this->items);
            // for ($index = 0; $index <= count($this->items); $index++) {
            //     if ($this->items[$index]['id'] == $id && $this->items[$index]['tamanho'] == $tamanho && $this->items[$index]['cor'] == $cor) {
            //         $storedItem = $this->items[$index];
            //         $itemIndex = $index;
            //         $index = count($this->items);
            //     }
            // }
            $count = 0;
            foreach ($this->items as $item) {
                if ($item['id'] == $id && $item['tamanho'] == $tamanho && $item['cor'] == $cor) {
                    $storedItem = $item;
                    $itemIndex = $count;
                }
                $count++;
            }
        }
        $storedItem['id'] = $id;
        $storedItem['qty'] += $qty;
        $storedItem['price'] = $price * $storedItem['qty'];
        $this->items[$itemIndex] = $storedItem;
    }

    public function remove($index)
    {
        $storedItem = $this->items[$index];
        $tshirt = Tshirt_image::find($storedItem['id']);

        $preco = Preco::find(1);
        if ($tshirt->cliente_id == null) {
            $price = $preco->unit_price_catalog;
        } else {
            $price = $preco->unit_price_own;
        }

        $storedItem['qty']--;
        $storedItem['price'] = $price * $storedItem['qty'];
        unset($this->items[$index]);
    }

    public function editQuantity($index, $operator)
    {
        $storedItem = $this->items[$index];
        $tshirt = Tshirt_image::find($storedItem['id']);

        $preco = Preco::find(1);
        if ($tshirt->customer_id == null) {
            $price = $preco->unit_price_catalog;
        } else {
            $price = $preco->unit_price_own;
        }

        if ($operator == '+') {
            $storedItem['qty']++;
        } else {
            if ($storedItem['qty'] > 1) {
                $storedItem['qty']--;
            }
        }
        $storedItem['price'] = $price * $storedItem['qty'];
        $this->items[$index] = $storedItem;
    }

    public function totalPrice()
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item['price'];
        }
        return $totalPrice;
    }

    public function totalQty()
    {
        $totalQty = 0;
        foreach ($this->items as $item) {
            $totalQty += $item['qty'];
        }
        return $totalQty;
    }
}
