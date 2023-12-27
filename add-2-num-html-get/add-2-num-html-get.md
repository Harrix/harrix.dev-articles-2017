---
date: 2017-05-05
categories: [it, web]
tags: [Клиент-сервер, HTML, Сложение двух чисел]
related-id: client-server
demo: demo
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-html-get/add-2-num-html-get.md
permalink: https://harrix.dev/ru/blog/2017/add-2-num-html-get/
lang: ru
attribution:
  - {
      author: W3C,
      author-site: "https://www.w3.org/html/logo/index.html",
      license: CC
        BY 3.0,
      license-url: "https://creativecommons.org/licenses/by/3.0/",
      permalink: "https://commons.wikimedia.org/wiki/File:HTML5_logo_and_wordmark.svg",
      permalink-date: 2019-02-24,
      name: HTML5 logo and wordmark.svg,
    }
---

# Сложение двух чисел в HTML (клиентское приложение)

![Featured image](featured-image.svg)

Напишем приложение сложение двух чисел на HTML, где сложение двух чисел происходит на стороне сервера.

## Постановка задачи

В [статье](https://github.com/Harrix/harrix.dev-blog-2015/blob/main/add-2-num-js/add-2-num-js.md) <!-- https://harrix.dev/ru/blog/2015/add-2-num-js/ --> показан пример приложения на HTML + JavaScript по сложению двух чисел. И там сложение двух чисел происходило в самом приложении, что логично. Серверной части там нет.

В [статье](https://github.com/Harrix/harrix.dev-blog-2015/blob/main/add-2-num-php/add-2-num-php.md) <!-- https://harrix.dev/ru/blog/2015/add-2-num-php/ --> показа пример приложения, где клиентская и серверная часть объединены в одном PHP скрипте.

А в этом приложении мы из полей ввода считаем два числа и отправим их на сервер, который сложит два числа, отправит нам ответ, и мы этот ответ отобразим в текстовом поле. То есть у нас клиентская и серверная часть разделены между собой.

На сервер поступает HTTP запрос с двумя переменными `a` и `b`. Переменные `a` и `b` передаются через GET параметры, то есть через адресную строку. Пример такого запроса:

```text
https://[путь с скрипту]?a=2&b=3
```

## Серверная часть

У вас должен быть сервер, доступный из интернета, к которому можно обращаться.

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-java-get/add-2-num-java-get.md) <!-- https://harrix.dev/ru/blog/2017/add-2-num-java-get/ --> приведен пример серверной части на Java.

В [статье](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-php-get/add-2-num-php-get.md) <!-- https://harrix.dev/ru/blog/2017/add-2-num-php-get/ --> приведен пример серверной части на PHP.

В статье буду использовать PHP скрипт, который я расположил по адресу <https://github.com/Harrix/harrix.dev-blog-2017/tree/main/add-2-num-php-get/demo> (если перейти по ссылке без параметров, то должно выдаваться `error`).

Пример запроса к серверу <https://github.com/Harrix/harrix.dev-blog-2017/tree/main/add-2-num-php-get/demo?a=2&b=3> (а вот тут должно появиться число `5`).

## Создание болванки

Создаем текстовой документ под именем `index.html`.

Закинем в него простую болванку HTML5 документа:

```html
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Программа сложения двух чисел</title>
  </head>
  <body></body>
</html>
```

Если мы сохраним документ и откроем в браузере, то увидим пустое белое окно, так как ничего видимого в документе пока нет — это просто болванка с шапкой, где располагаются некоторые мета-тэги (по сути их тоже можно было выкинуть), и пустое тело.

## Наполнение HTML

Так как так нам нужно приложение, которое будет складывать два числа, то нужно два поля ввода текстовой информации. Следовательно, их нужно будет размещать в некоторой форме. Поэтому в теле HTML документа `<body></body>` разместим такую форму:

```html
<form>
  <input name="a" type="text" value="2" /><br />
  <input name="b" type="text" value="3" /><br />
</form>
```

Каждое поле имеет своё имя `name` (не `id`) с названием переменной `a` и `b`. Также они имеют начальное наполнение.

Нам нужна кнопка для вычислений. Обычно на форме используется `input` тэг с `type=submit`:

```html
<input type="submit" value="Сложить 2 два числа" />
```

У нас сложение двух чисел будет происходить не на стороне клиента, а на стороне сервера. Поэтому форме нужно указать адрес сервера, куда мы отправим запрос:

```html
<form
  action="https://harrix.dev/blog/2017/add-2-num-php-get/demo"
  method="get"
></form>
```

Общий документ будет иметь вид:

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
    <form
      action="https://harrix.dev/blog/2017/add-2-num-php-get/demo"
      method="get"
    >
      <input name="a" type="text" value="2" /><br />
      <input name="b" type="text" value="3" /><br />
      <input type="submit" value="Сложить 2 два числа" />
    </form>
  </body>
</html>
```

Если мы сохраним документ и его откроем, то получим следующее:

![Получившаяся HTML страница](img/result_01.png)

_Рисунок 1 — Получившаяся HTML страница_

Если нажмем на кнопку, то мы перейдем на страницу сервера, где будет отображен результат работы сервера:

![Результат выполнения программы](img/result_02.png)

_Рисунок 2 — Результат выполнения программы_
