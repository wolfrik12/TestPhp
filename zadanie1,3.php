<?php
// Задание 1 
$categories = array(
    array(
        "id" => 1,
        "title" => "Обувь",
        'children' => array(
            array(
                'id' => 2,
                'title' => 'Ботинки',
                'children' => array(
                    array('id' => 3, 'title' => 'Кожа'),
                    array('id' => 4, 'title' => 'Текстиль'),
                ),
            ),
            array(
                'id' => 5,
                'title' => 'Кроссовки',
            ),
            
        )
    ),
    array(
        "id" => 6,
        "title" => "Спорт",
        'children' => array(
            array(
                'id' => 7,
                'title' => 'Мячи'
            )
        )
    ),
);

function searchCategory($categories, $id)
{
    foreach ($categories as $category) {
        if ($category['id'] === $id) {
            return $category['title'];
        }

        if (isset($category['children'])) {
            $result = searchCategory($category['children'], $id);
            if ($result !== null) {
                return $result;
            }
        }
    }

    return null; // не найдено
}



echo ("<h3>Задание 1 : </h1>");
echo searchCategory($categories, 4); // Выведет: по id текстиль
echo searchCategory($categories, 7); // Выведет: по id Мячи
echo ("</br>");
echo ("<h3>Задание 3 : </h1>");
//Задание 3 
function isCorrectHTMLStructure($tagsArray)
{
    $stack = array();

    foreach ($tagsArray as $tag) {

        if (strpos($tag, '</') === false) {
            // Добавляем  в массив
            array_push($stack, $tag);
        } else {
            // проверка с последним
            $lastTag = array_pop($stack);

            // если не соответсвует
            if ($lastTag === null || $lastTag !== substr($tag, 1, -1)) {
                return false;
            }
        }
    }

    // если сооттвествует
    return empty($stack);
}

// Пример использования:
$tagsSequence1 = ["<a>", "<div>", "</div>", "</a>", "<span>", "</span>"];
$tagsSequence2 = ["<a>", "<div>", "</a>"];

var_dump(isCorrectHTMLStructure($tagsSequence1)); // Выведет: bool(true)
var_dump(isCorrectHTMLStructure($tagsSequence2)); // Выведет: bool(false)


?>
<?php

interface StorageInterface {
    public function setData($key, $value);
    public function getData($key);
    public function save();
    public function load();
}

abstract class AbstractBox implements StorageInterface {
    protected $data = [];

    public function setData($key, $value) {
        $this->data[$key] = $value;
    }

    public function getData($key) {
        return $this->data[$key] ?? null;
    }
}

class FileBox extends AbstractBox {
    private $filename;
    private static $instance;

    private function __construct($filename) {
        $this->filename = $filename;
    }

    public static function getInstance($filename) {
        if (!isset(self::$instance)) {
            self::$instance = new FileBox($filename);
        }
        return self::$instance;
    }

    public function save() {
        file_put_contents($this->filename, serialize($this->data));
    }

    public function load() {
        if (file_exists($this->filename)) {
            $data = file_get_contents($this->filename);
            $this->data = unserialize($data);
        }
    }
}

class DbBox extends AbstractBox {
    private static $instance;

    private function __construct() {
        // Добавьте код для инициализации подключения к базе данных
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new DbBox();
        }
        return self::$instance;
    }

    public function save() {
        // Добавьте код для сохранения данных в базу
    }

    public function load() {
        // Добавьте код для загрузки данных из базы и сохранения в $this->data
    }
}

// Пример использования FileBox
$fileBox = FileBox::getInstance('data.txt');
$fileBox->setData('name', 'Alice');
$fileBox->setData('age', 25);
$fileBox->save();

// Чтение данных из файла
$fileBox->load();
$name = $fileBox->getData('name'); // 'Alice'
$age = $fileBox->getData('age'); // 25

// Пример использования DbBox
$dbBox = DbBox::getInstance();
$dbBox->setData('name', 'Bob');
$dbBox->setData('age', 30);
$dbBox->save();

// Чтение данных из базы
$dbBox->load();
$name = $dbBox->getData('name'); // 'Bob'
$age = $dbBox->getData('age'); // 30