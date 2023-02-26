---
date: 2017-04-25
categories: [it, programming]
tags: [Visual Studio]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/start-without-debugging-vs/start-without-debugging-vs.md
permalink: https://harrix.dev/ru/blog/2017/start-without-debugging-vs/
lang: ru
---

# Кнопка «Запуск без отладки» на панели инструментов в Visual Studio

![Featured image](featured-image.svg)

Выводим кнопку запуска приложения в панель инструментов.

При написании консольных приложений в Visual Studio у начинающих возникает проблема, что при выводе результата приложение закрывается, не дав взглянуть на ответ.

Можно использовать `system("pause")`, `_getch()`. Но можно использовать запуск приложения без отладки `Ctrl` + `F5`. Тогда приложения после завершения работы не закроет окно консоли. Но данная кнопка отсутствует по умолчанию в панели инструментов:

![Кнопка «Запуск без отладки»](img/panel_01.png)

_Рисунок 1 — Кнопка «Запуск без отладки»_

В панели инструментов вызываем контекстное меню правой кнопкой:

![Контекстное меню](img/panel_02.png)

_Рисунок 2 — Контекстное меню_

![Добавление команды](img/panel_03.png)

_Рисунок 3 — Добавление команды_

![Выбор команды](img/panel_04.png)

_Рисунок 4 — Выбор команды_

![Размещение команды](img/panel_05.png)

_Рисунок 5 — Размещение команды_

![Кнопка «Запуск без отладки» на панели инструментов](img/panel_06.png)

_Рисунок 6 — Кнопка «Запуск без отладки» на панели инструментов_
