<?php
/*
Abstract FactoryでDaoをモックする。

[PHPによるデザインパターン入門 \- Abstract Factory～関連する部品をまとめて作る工場 \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141215/1418620420)

生成するものについての実装もする必要はなく、共通のAPIを使って開発ができる。
interfaceだけを意識して開発するをFactoryといった感じ。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{

    $factores = [new DbFactory, new MockFactory];
    foreach ($factores as $factory) {
        puts('[ '.get_class($factory).' ]');
        $itemId = 1;
        $itemDao = $factory->createItemDao();
        $item = $itemDao->findById($itemId);
        dump($item);

        $orderId = 3;
        $orderDao = $factory->createOrderDao();
        $order = $orderDao->findById($orderId);
        dump($order);

        puts('');
    }
}

interface DaoFactory
{
    public function createItemDao() : ItemDao;
    public function createOrderDao() : OrderDao;
}

// 各DaoにはfindByIdがあると限らないので、インターフェースDaoは定義しないのかも。
interface ItemDao
{
    public function findById(int $itemId) : Item;
}

interface OrderDao
{
    public function findById(int $orderId) : Order;
}

// アクセサは省略
class Item
{
    public $id;
    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class Order
{
    public $id;
    public $items = [];

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function addItem(Item $item)
    {
        $id = $item->id;
        if (!array_key_exists($id, $this->items)) {
            $this->items[$id] = [
                'object' => $item,
                'amount' => 0,
            ];
        }
        $this->items[$id]['amount']++;
    }
}

/***********/
/* Facotry */
/***********/

class DbFactory implements DaoFactory
{
    public function createItemDao() : ItemDao
    {
        return new DbItemDao;
    }

    public function createOrderDao() : OrderDao
    {
        return new DbOrderDao($this->createItemDao());
    }
}

class DbItemDao implements ItemDao
{
    private $items;

    public function __construct()
    {
        global $items;
        foreach ($items as $item) {
            $item = new Item($item->id, $item->name);
            $this->items[$item->id] = $item;
        }
    }

    public function findById(int $itemId) : Item
    {
        return $this->items[$itemId] ?? null;
    }
}

class DbOrderDao implements OrderDao
{
    private $orders;

    public function __construct(ItemDao $itemDao)
    {
        global $orders;
        foreach ($orders as $row) {
            $order = new Order($row->id);
            foreach (explode(',', $row->item_ids) as $itemId) {
                $item = $itemDao->findById($itemId);
                if (!is_null($item)) {
                    $order->addItem($item);
                }
            }
            $this->orders[$order->id] = $order;
        }
    }

    public function findById(int $orderId) : Order
    {
        return $this->orders[$orderId] ?? null;
    }
}


/********/
/* Mock */
/********/

class MockFactory implements DaoFactory
{
    public function createItemDao() : ItemDao
    {
        return new MockItemDao;
    }

    public function createOrderDao() : OrderDao
    {
        return new MockOrderDao;
    }
}

class MockItemDao implements ItemDao
{
    public function findById(int $itemId) : Item
    {
        $item = new Item('99', 'dummy product 99');
        return $item;
    }
}

class MockOrderDao implements OrderDao
{
    public function findById(int $orderId) : Order
    {
        $order = new Order('999');
        $order->addItem(new Item('99', 'dummy product 99'));
        $order->addItem(new Item('99', 'dummy product 99'));
        $order->addItem(new Item('98', 'dummy product 98'));

        return $order;
    }
}

/************/
/* Database */
/************/

$items = [
    (object)[
        'id' => 1,
        'name' => 'T-Shirt',
    ],
    (object)[
        'id' => 2,
        'name' => 'Stuffed animal',
    ],
    (object)[
        'id' => 3,
        'name' => 'Cookie set',
    ],
];

$orders = [
    (object)[
        'id' => 1,
        'item_ids' => '1,3',
    ],
    (object)[
        'id' => 2,
        'item_ids' => '2',
    ],
    (object)[
        'id' => 3,
        'item_ids' => '1,1,1,2,3,3',
    ],
];

run();
