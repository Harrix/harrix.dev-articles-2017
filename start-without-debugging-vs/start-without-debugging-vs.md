---
date: 2017-04-25
categories: [it, programming]
tags: [Visual Studio]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/start-without-debugging-vs/start-without-debugging-vs.md
url: https://harrix.dev/ru/blog/2017/start-without-debugging-vs/
lang: ru
---

# Кнопка «Запуск без отладки» на панели инструментов в Visual Studio

![Featured image](featured-image.svg)

Выводим кнопку запуска приложения в панель инструментов.

При написании консольных приложений в Visual Studio у начинающих возникает проблема, что при выводе результата приложение закрывается, не дав взглянуть на ответ.

Можно использовать `system("pause")`, `_getch()`. Но можно использовать запуск приложения без отладки `Ctrl` + `F5`. Тогда приложения после завершения работы не закроет окно консоли. Но данная кнопка отсутствует по умолчанию в панели инструментов:

![Кнопка «Запуск без отладки»](img/panel_01.png)

В панели инструментов вызываем контекстное меню правой кнопкой:

![Контекстное меню](img/panel_02.png)

![Добавление команды](img/panel_03.png)

![Выбор команды](img/panel_04.png)

![Размещение команды](img/panel_05.png)

![Кнопка «Запуск без отладки» на панели инструментов](img/panel_06.png)
