---
date: 2017-05-05
categories: [it, web]
tags: [Клиент-сервер, Java, Сложение двух чисел]
related-id: client-server
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-java-post/add-2-num-java-post.md
permalink: https://harrix.dev/ru/articles/2017/add-2-num-java-post/
lang: ru
---

# Сложение двух чисел на JAVA с передачей параметров через POST (серверное приложение)

![Featured image](featured-image.svg)

Рассмотрен пример сервлета на Java, который делает то же самое, что и [PHP скрипт](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-php-post/add-2-num-php-post.md) <!-- https://harrix.dev/ru/articles/2017/add-2-num-php-post/ -->: складывает два числа, которые пришли из клиента.

В [статье](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-java-get/add-2-num-java-get.md) <!-- https://harrix.dev/ru/articles/2017/add-2-num-java-get/ --> показан сервлет, который работает также, но с параметрами, переданными через GET.

## Приготовления

В статье [Простейшее web-приложение на Java на сервере Tomcat](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/tomcat/tomcat.md) <!-- https://harrix.dev/ru/articles/2017/tomcat/ --> рассмотрен пример простейшего сервлета с инструкцией по установке и поднятии сервера `Tomcat`. Поэтому в этой статье я не буду рассматривать подробно процесс компилирования Java файлов в class файлы, создание папок для нашего приложения. Для этого обратитесь в вышеприведенную статью.

## Постановка задачи

На сервер поступает HTTP запрос с двумя переменными `a` и `b`. Сервер должен считать два числа, сложить их и вернуть эту сумму клиенту. Переменные `a` и `b` передаются через POST параметры.

## Java сервлет

Общий вид Java сервлета `TestServlet.java` приведен ниже:

```java
package com.example;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class TestServlet extends HttpServlet {

    public void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        resp.setContentType("text/html;charset=utf-8");

        PrintWriter pw = resp.getWriter();

        pw.println("error");
    }

    public void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        resp.setContentType("text/html;charset=utf-8");

        PrintWriter pw = resp.getWriter();

        Integer a = 0, b = 0, c = 0;
        Boolean Error = false;

        String param_a = req.getParameter("a");
        String param_b = req.getParameter("b");

        try {
            a = Integer.parseInt(param_a);
            b = Integer.parseInt(param_b);
        }
        catch (NumberFormatException e) {
            Error = true;
        }

        if (Error) {
       pw.println("error");
    }
    else {
      c = a + b;

      pw.println(c);
    }

    }
}
```

Разберем код.

Как вы понимаете, метод `doGet()` предназначен для обработки GET параметров, а `doPost()` для обработки POST параметров.

Метод `doGet()` добавлен как заглушка, чтобы Tomcat не выдавал свою страницу ошибки при отправке GET запросов. Например, если обратиться к странице через браузер, введя адрес в адресной строке.

В нашем главном методе `doPost()` есть два параметра: `HttpServletRequest req` — запрос от клиента, `HttpServletResponse resp` ответ клиенту. Поэтому мы в переменную `resp` будем записывать результат, а из переменной `req` вытаскивать данные.

И следующие строчки вытаскивают POST параметры `a` и `b` в виде строковых переменных:

```java
String param_a = req.getParameter("a");
String param_b = req.getParameter("b");
```

Потом пытаемся перевести эти строки в числа. Но так как мало ли что было передано в качестве параметров (а может вообще ничего от клиента в этих параметрах не пришло), то обрамляем процесс перевода в конструкцию `try catch`:

```java
try {
    a = Integer.parseInt(param_a);
    b = Integer.parseInt(param_b);
}
catch (NumberFormatException e) {
    Error = true;
}
```

Если в процессе получения значений `a` и `b` произошли проблемы, то выводим `error`, иначе сумму двух чисел:

```java
if (Error) {
     pw.println("error");
}
else {
    c = a + b;

    pw.println(c);
}
```

## Сборка сервлета

Создадим где-нибудь папку `[папка]`. У меня это `testapp` на рабочем столе с полным путем `C:\Users\User\Desktop\testapp`.

В ней должны быть такие два файла.

`[папка]\com\example\TestServlet.java`

`[папка]\servlet-api.jar`

В командной строке переходим в папку командой:

```java
cd [полный путь к папке]
```

У меня это:

```java
cd C:\Users\User\Desktop\testapp
```

Собираем `TestServlet.class` командой:

```java
javac -encoding UTF-8 -cp .;servlet-api.jar com\example\*.java
```

В папке `[папка]\com\example\` должен появиться файл `TestServlet.class`.

В папке Tomcat (у меня это `C:\Program Files\Apache Software Foundation\Tomcat 9.0`) переходим в папку `webapps`.

В ней создаем папку с названием вашего web-приложения, например, `testingapp`.

В этой папке должны быть два файла:

- `…\WEB-INF\classes\com\example\TestServlet.class`;
- `…\WEB-INF\web.xml`.

Файл `web.xml` будет вот с таким, например, содержимым:

```xml
<!DOCTYPE web-app PUBLIC '-//Sun Microsystems, Inc.//DTD
  Web Application 2.3//EN' 'http://java.sun.com/dtd/web-app_2_3.dtd'>

<web-app>

  <servlet>
    <servlet-name>test</servlet-name>
    <servlet-class>com.example.TestServlet</servlet-class>
  </servlet>

  <servlet-mapping>
    <servlet-name>test</servlet-name>
    <url-pattern>/test</url-pattern>
  </servlet-mapping>

</web-app>
```

Перезапускаем сервер Tomcat.

Если что-то пошло не так или какой-то шаг непонятен, то читаем [статью](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/tomcat/tomcat.md) <!-- https://harrix.dev/ru/articles/2017/tomcat/ -->.

## Проверка работы

Наш сервлет находится по адресу <http://localhost:8080/testingapp/test>. Если мы перейдем по нему, то получим `error`. Это у нас сработает `doGet()` метод.

Через адресную строку в браузере, разумеется, POST параметры не отправить. Для этого используются либо формы в HTML страницах, либо через запросы в клиентских приложениях.

Работу приложения можно проверить через данный HTML файл:

```xml
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Программа сложения двух чисел</title>
</head>

<body>
  <form action="http://localhost:8080/testingapp/test" method="post">
    <input name="a" type="text" value="2"><br>
    <input name="b" type="text" value="3"><br>
    <input type="submit" value="Сложить 2 два числа">
  </form>
</body>

</html>
```

В [статье](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-php-post/add-2-num-php-post.md) <!-- https://harrix.dev/ru/articles/2017/add-2-num-php-post/ --> рассмотрен пример web-приложения на PHP, который делает тоже самое.
