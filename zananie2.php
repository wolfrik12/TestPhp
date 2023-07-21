
SELECT
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
    // MAX(car.model) чтоб выводило одно значение посстоянно 
    