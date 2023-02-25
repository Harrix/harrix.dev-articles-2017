---
date: 2017-05-07
categories: [it, web]
tags: [Клиент-сервер, PHP, Сложение двух чисел, JSON]
related-id: client-server
demo: demo
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-post-json/add-2-num-php-post-json.md
url: https://harrix.dev/ru/blog/2017/add-2-num-php-post-json/
lang: ru
---

# Сложение двух чисел на PHP с передачей параметров через POST и генерацией JSON (серверное приложение)

В отличии от статьи [Сложение двух чисел в HTML с передачей параметров через POST](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-post/add-2-num-php-post.md) сервер в качестве ответа формирует JSON файл.

## Приготовления

Нам потребуется так или иначе сервер, на котором просчитываются PHP скрипты. Можно установить локальный сервер (например, [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/apache-php-mysql/apache-php-mysql.md) описано) через установку связки Apache + PHP + MySQL + phpMyAdmin, можно воспользоваться уже готовыми сборками (Denver, Open Server, WampServer и др.). Можно использовать сервер на каком-нибудь виртуальном хостинге и так далее. В общем, вариантов много.

Далее предполагается, что у вас есть такой сервер, вы умеете запускать в браузере PHP скрипты (если не знаете, то или [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/apache-php-mysql/apache-php-mysql.md) почитайте или в любом другом месте в учебниках по PHP).

## Постановка задачи

На сервер поступает HTTP запрос с двумя переменными `a` и `b`. Сервер должен считать два числа, сложить их и вернуть эту сумму клиенту в виде JSON файла. Переменные `a` и `b` передаются через POST параметры.

Если данные не переданы, то должно вывестись слово `error`.

JSON файл должен содержать информацию о слагаемых и сумме чисел. Например, так:

```json
{ "a": 2, "b": 3, "c": 5 }
```

## PHP скрипт

Общий вид PHP скрипта `index.php` приведен ниже:

```php
<?php
if (isset($_POST['a'])) $string_a = htmlentities($_POST['a']);
if (isset($_POST['b'])) $string_b = htmlentities($_POST['b']);

$isEmpty = false;
if ((empty($string_a)) || (empty($string_b))) $isEmpty = true;

if (!$isEmpty) {
  $a = (int)$string_a;
  $b = (int)$string_b;

  $c = $a + $b;

  // Формируем JSON ответ от сервера
  $arr = array('a' => $a, 'b' => $b, 'c' => $c);
  echo json_encode($arr);
}
else {
  echo "error";
}
?>
```

По сравнению со статьей [Сложение двух чисел в HTML с передачей параметров через POST](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-post/add-2-num-php-post.md) тут строчка `echo $c;` поменялась на следующие строчки:

```php
$arr = array('a' => $a, 'b' => $b, 'c' => $c);
echo json_encode($arr);
```

То есть в PHP есть готовая функция [json_encode](https://www.php.net/manual/ru/function.json-encode.php), которая переводит массив в JSON формат.

## Проверка работы

Закидываем данный скрипт на сервер. Я закинул на <https://github.com/Harrix/harrix.dev-blog-2017/tree/main/add-2-num-php-post-json/demo>

Через адресную строку в браузере, разумеется, POST параметры не отправить. Для этого используются либо формы в HTML страницах, либо через запросы в клиентских приложениях.

Можно проверить через данный [HTML файл](demo/check.html):

```html
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Программа сложения двух чисел</title>
  </head>

  <body>
    <form action="http://demo.harrix.org/demo0013/" method="post">
      <input name="a" type="text" value="2" /><br />
      <input name="b" type="text" value="3" /><br />
      <input type="submit" value="Сложить 2 два числа" />
    </form>
  </body>
</html>
```

При отправке чисел `2` и `3` получим в результате вот в виде полноценного JSON файл, который мы уже можем парсить, если нужно:

```json
{ "a": 2, "b": 3, "c": 5 }
```
