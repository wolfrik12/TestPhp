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