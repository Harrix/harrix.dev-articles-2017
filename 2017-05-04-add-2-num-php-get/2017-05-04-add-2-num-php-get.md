---
categories: [it, web]
tags: [Клиент-сервер, PHP, Сложение двух чисел]
related-id: client-server
demo: demo
---

# Сложение двух чисел на PHP с передачей параметров через GET (серверное приложение)

В отличии от статьи [Сложение двух чисел на HTML + PHP](https://github.com/Harrix/harrix.dev-blog-2015/tree/main/2015-07-14-add-2-num-php) тут рассматривается пример web-приложения без использования HTML — только серверная часть. Подобные приложения могут использоваться для клиент-серверных приложений, когда клиент отправляет на сервер запрос, сервер формирует ответ и возвращает клиенту.

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-05-add-2-num-php-post) рассматривается вариант с POST запросом.

## Приготовления

Нам потребуется так или иначе сервер, на котором просчитываются PHP скрипты. Можно установить локальный сервер (например, [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/2018-10-04-apache-php-mysql/2018-10-04-apache-php-mysql.md) описано) через установку связки Apache + PHP + MySQL + phpMyAdmin, можно воспользоваться уже готовыми сборками (Denver, Open Server, WampServer и др.). Можно использовать сервер на каком-нибудь виртуальном хостинге и так далее. В общем, вариантов много.

Далее предполагается, что у вас есть такой сервер, вы умеете запускать в браузере PHP скрипты (если не знаете, то или [тут](https://github.com/Harrix/harrix.dev-blog-2018/blob/main/2018-10-04-apache-php-mysql/2018-10-04-apache-php-mysql.md) почитайте или в любом другом месте в учебниках по PHP).

## Постановка задачи

На сервер поступает HTTP запрос с двумя переменными `a` и `b`. Сервер должен считать два числа, сложить их и вернуть эту сумму клиенту. Переменные `a` и `b` передаются через GET параметры, то есть через адресную строку. Пример такого запроса:

```text
https://[путь с скрипту]?a=2&b=3
```

Пример скрипта на моем сайте:

```text
https://harrix.dev/blog/2017/add-2-num-php-get/demo?a=2&b=3
```

Если данные не переданы, то должно вывестись слово `error`.

## PHP скрипт

Общий вид PHP скрипта `index.php` приведен ниже:

```php
<?php
if (isset($_GET['a'])) $string_a = htmlentities($_GET['a']);
if (isset($_GET['b'])) $string_b = htmlentities($_GET['b']);

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

Разберем его.

В эти строчках мы считываем наши параметры в виде строковых переменных из GET параметров. Причем стараемся себе обезопасить, экранировав служебные символы функцией `htmlentities`, чтобы нельзя было передать через значения переменных зловредный код:

```php
if (isset($_GET['a'])) $string_a = htmlentities($_GET['a']);
if (isset($_GET['b'])) $string_b = htmlentities($_GET['b']);
```

Значения GET переменных могут отсутствовать (например, вместо `http://[путь с скрипту]?a=2&b=3` был запрос `http://[путь с скрипту]`). В этом случае сервер должен вывести `error`. Поэтому проверяем переменные на пустоту содержимого:

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

Рассмотрим работу скрипта на тестовом примере. У меня скрипт залит по адресу [demo/](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-04-add-2-num-php-get/demo) (если перейти по ссылке без параметров, то должно выдаваться `error`).

При вызове [demo/](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-04-add-2-num-php-get/demo) мы получим `error`, так как данные не переданы.

При вызове [demo?a=2](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-04-add-2-num-php-get/demo?a=2) мы получим `error`, так как переменная `b` не передана.

При вызове [demo?a=2&b=3](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-04-add-2-num-php-get/demo?a=2&b=3) мы получим `5`.

При вызове [demo?a=harrix&b=3](https://github.com/Harrix/harrix.dev-blog-2017/tree/main/2017-05-04-add-2-num-php-get/demo?a=harrix&b=3) мы получим `3`, так как строка `harrix` была переведена в число `0`.

## Дополнительные ссылки

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/2017-05-04-add-2-num-java-get/2017-05-04-add-2-num-java-get.md) рассмотрен пример web-приложения на Java, который делает тоже самое.

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/2017-05-05-add-2-num-apache-http/2017-05-05-add-2-num-apache-http.md) и [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/2017-05-05-add-2-num-http-url-connection/2017-05-05-add-2-num-http-url-connection.md) рассматривается пример создания клиентского приложения на Android Studio.

В статье [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/2017-05-05-add-2-num-html-get/2017-05-05-add-2-num-html-get.md) рассматривается пример создания клиентского приложения на HTML.
