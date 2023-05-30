<?

$data = [
    ['id' => 1, 'date' => "12.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "02.05.2020", 'name' => "test2"],
    ['id' => 4, 'date' => "08.03.2020", 'name' => "test4"],
    ['id' => 1, 'date' => "22.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "11.11.2020", 'name' => "test4"],
    ['id' => 3, 'date' => "06.06.2020", 'name' => "test3"],
];

$result1 = $this->task1($data);
$result2 = $this->task2($data);
$result3 = $this->task3($data, 4);
$result4 = $this->task4($data);
$result5 = $this->task5();
$result6 = $this->task6();
$result6_2 = $this->task6_2();

function task1(array $data)
{
    $unique = [];
    array_map(function($item)use(&$unique){
        $unique[$item['id']] = $item;
    }, $data);
    return $unique;
}

function task2(array $data)
{
    array_multisort(array_column($data,'id'), $data);
    return $data;
}

function task3(array $data, $id = 0)
{
    return array_filter($data, fn($item) => $item['id'] == $id);
}

function task4(array $data)
{
    return array_map(fn($item) => [$item['name'] => $item['id']], $data);
}

function task5()
{
    return "
        SELECT g.id, g.name
        FROM goods as g
        JOIN goods_tags as gt ON g.id = gt.goods_id
        GROUP BY g.id
        HAVING COUNT(gt.tag_id) = (SELECT COUNT(tags.id) FROM tags)
    ";
}

function task6()
{
    return "
        SELECT department_id
        FROM evaluations
        WHERE gender = true
        GROUP BY department_id
        HAVING MIN(value) > 5
    ";
}

/**
 * Возможно Вы забыли упомянуть что есть таблица "departments"
 * так как по ТЗ требуются именно Департаменты, а не только их id
 */
function task6_2()
{
    return "
        SELECT *
        FROM departments
        WHERE id IN (
            SELECT department_id
            FROM evaluations
            WHERE gender = true
            GROUP BY department_id
            HAVING MIN(value) > 5
        )
    ";
}