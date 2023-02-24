---
date: 2017-05-05
categories: [it, web]
tags: [Клиент-сервер, PHP, Сложение двух чисел]
related-id: client-server
demo: demo
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
---

# Сложение двух чисел на PHP с передачей параметров через POST (серверное приложение)

В отличии от статьи [Сложение двух чисел на HTML + PHP](https://github.com/Harrix/harrix.dev-blog-2015/blob/main/add-2-num-php/add-2-num-php.md) тут рассматривается пример web-приложения без использования HTML — только серверная часть. Подобные приложения могут использоваться для клиент-серверных приложений, когда клиент отправляет на сервер запрос, сервер формирует ответ и возвращает клиенту.

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-get/add-2-num-php-get.md) рассматривается вариант с GET запросом.

## Приготовления

Нам потребуется так или иначе сервер, на котором просчитываются PHP скрипты. Можно установить локальный сервер (например, [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/apache-php-mysql/apache-php-mysql.md) описано) через установку связки Apache + PHP + MySQL + phpMyAdmin, можно воспользоваться уже готовыми сборками (Denver, Open Server, WampServer и др.). Можно использовать сервер на каком-нибудь виртуальном хостинге и так далее. В общем, вариантов много.

Далее предполагается, что у вас есть такой сервер, вы умеете запускать в браузере PHP скрипты (если не знаете, то или [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/apache-php-mysql/apache-php-mysql.md) почитайте или в любом другом месте в учебниках по PHP).

## Постановка задачи

На сервер поступает HTTP запрос с двумя переменными `a` и `b`. Сервер должен считать два числа, сложить их и вернуть эту сумму клиенту. Переменные `a` и `b` передаются через POST параметры.

Если данные не переданы, то должно вывестись слово `error`.

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

  echo $c;
}
else {
  echo "error";
}
?>
```

Разберем данный код.

В строчках ниже мы считываем наши параметры в виде строковых переменных из POST параметров. Причем стараемся себе обезопасить, экранировав служебные символы функцией `htmlentities`, чтобы нельзя было передать через значения переменных зловредный код. Кстати, в этих двух строчках единственное отличие от кода для передачи параметров [через GET](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-get/add-2-num-php-get.md):

```php
if (isset($_POST['a'])) $string_a = htmlentities($_POST['a']);
if (isset($_POST['b'])) $string_b = htmlentities($_POST['b']);
```

Значения POST переменных могут отсутствовать. В этом случае сервер должен вывести `error`. Поэтому проверяем переменные на пустоту содержимого:

```php
$isEmpty = false;
if ((empty($string_a)) || (empty($string_b))) $isEmpty = true;
```

Переводим строчки в числа:

```php
$a = (int)$string_a;
$b = (int)$string_b;
```

А дальше складываем числа и выводим сумму клиенту через команду `echo`.

## Проверка работы

Закидываем данный скрипт на сервер. Я закинул на <https://github.com/Harrix/harrix.dev-blog-2017/tree/main/add-2-num-php-post/demo>

Через адресную строку в браузере, разумеется, POST параметры не отправить. Для этого используются либо формы в HTML страницах, либо через запросы в клиентских приложениях.

Работу скрипта можно проверить через данный [HTML файл](demo/check.html):

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
    <form action="https://harrix.dev/blog/2017/add-2-num-php-post/demo/" method="post">
      <input name="a" type="text" value="2" /><br />
      <input name="b" type="text" value="3" /><br />
      <input type="submit" value="Сложить 2 два числа" />
    </form>
  </body>
</html>
```
