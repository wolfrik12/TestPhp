
<!-- SELECT
    worker.first_name,
    worker.last_name,
    (
        SELECT GROUP_CONCAT(child.name SEPARATOR ', ')
        FROM child
        WHERE child.user_id = worker.id
    ) AS children,
    (
        SELECT MAX(car.model)
        FROM car
        WHERE car.user_id = worker.id
    ) AS model
FROM
    worker;
    // GROUP_CONCAT - магия превращения в одну строку
    // MAX(car.model) чтоб выводило одно значение посстоянно  -->
    <?php


interface BoxInterface {
    public function setData($key, $value);
    public function getData($key);
    public function save();
    public function load();
}

// Класс-оболочка FileBox
class FileBox implements BoxInterface {
    private $data = [];
// название файла
    private $file = 'data.txt';

    public function setData($key, $value) {
        $this->data[$key] = $value;
    }

    public function getData($key) {
        return $this->data[$key] ?? null;
    }
// сохранение в виде file_put - запись в файл,serialize преоброзование в строку
    public function save() {
        file_put_contents($this->file, serialize($this->data));
    }
// unserialize - возвращает обратно
    public function load() {
        if (file_exists($this->file)) {
            $data = file_get_contents($this->file);
            $this->data = unserialize($data);
        }
    }
}

// пример
$fileBox = new FileBox();
$fileBox->setData('name', 'Дима Зубков');
$fileBox->setData('age', 20);
$fileBox->save();

$loadedBox = new FileBox();
$loadedBox->load();
echo $loadedBox->getData('name');
echo $loadedBox->getData('age');  

 
