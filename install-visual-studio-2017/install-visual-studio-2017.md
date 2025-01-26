---
date: 2017-04-13
categories:
  - it
  - program
tags:
  - Установка
  - Visual Studio
  - C++
update: 2019-07-14
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/install-visual-studio-2017/install-visual-studio-2017.md
permalink: https://harrix.dev/ru/articles/2017/install-visual-studio-2017/
lang: ru
attribution:
  - author: Microsoft Corporation
    author-site: https://www.microsoft.com/
    license: Public domain
    license-url: https://en.wikipedia.org/wiki/Public_domain
    permalink: https://commons.wikimedia.org/wiki/File:Visual_Studio_2017_Logo.svg
    permalink-date: 2019-06-08
    name: Visual Studio 2017 Logo.svg
---

# Установка Visual Studio 2017 Community

![Featured image](featured-image.svg)

В статье приведена инструкция по установке бесплатной версии Visual Studio 2017 Community на Windows 10 для программирования на C++. По сравнению с версией 2015 процесс установки сильно изменился.

Так как уже вышла [Visual Studio 2019](https://github.com/Harrix/harrix.dev-articles-2021/blob/main/install-visual-studio-2019/install-visual-studio-2019.md) | [🡥](https://harrix.dev/ru/articles/2021/install-visual-studio-2019/), то Visual Studio 2017 нужно искать на странице со старыми релизами.

Переходим на адрес загрузки предыдущих версий `Visual Studio`: <https://visualstudio.microsoft.com/ru/vs/older-downloads/>.

Выбираем загрузку версии 2017:

![Скачивание установщика](img/download_01.png)

_Рисунок 1 — Скачивание установщика_

И там выбираем версию установщика под нашу операционную систему:

![Выбор установщика](img/download_02.png)

_Рисунок 2 — Выбор установщика_

Запускаем скаченный файл:

![Начальное окно установщика](img/install_01.png)

_Рисунок 3 — Начальное окно установщика_

![Подзагрузка нужных файлов](img/install_02.png)

_Рисунок 4 — Подзагрузка нужных файлов_

После этого откроется окно с большим количеством пакетов для скачивания и установки в `Visual Studio`. Там и средства для программирования для мобильных устройств и под Node.js и так далее. Причем каждый пункт имеет справа список загружаемых файлов.

Нас интересует программирование на C++ под обычный Windows.

Если вы хотите программировать так называемые универсальные приложения (это те, что с Metro стилем и могут распространяться с магазином), то выберите первый блок и такие подпункты справа (обратите внимание, что пакет `Windows 10 SDK` лучше выбирать последний версии, который будет показываться у вас):

![Пакеты для UWP приложений](img/install_03.png)

_Рисунок 5 — Пакеты для UWP приложений_

Для классических приложений выберите эти пакеты:

![Пакеты для классических приложений под .NET](img/install_04.png)

_Рисунок 6 — Пакеты для классических приложений под .NET_

![Пакеты для классических приложений](img/install_05.png)

_Рисунок 7 — Пакеты для классических приложений_

Лично я еще удаляю пакет русского языка и устанавливаю только английский язык. Но это исключительно на ваш выбор:

![Выбор языковых пакетов](img/languages.png)

_Рисунок 8 — Выбор языковых пакетов_

После выбора пакетов нужно запустить долгую-долгую установку:

![Процесс установки](img/install_06.png)

_Рисунок 9 — Процесс установки_

После установки всех пакетов запустите Visual Studio:

![Первое окно при запуске Visual Studio](img/install_07.png)

_Рисунок 10 — Первое окно при запуске Visual Studio_

Настоятельно рекомендую войти под учетной записью Visual Studio, чтобы через месяц программа не перестала работать (не проверял в 2017 версии, но в 2015 через месяц работы в незарегистрированной Community версии программа перестала запускаться, говоря, что нужно всё-таки войти под учеткой):

![Вход в учетку](img/install_08.png)

_Рисунок 11 — Вход в учетку_

![Вход в учетку](img/install_09.png)

_Рисунок 12 — Вход в учетку_

![Вход в учетку](img/install_10.png)

_Рисунок 13 — Вход в учетку_

После этого откроется готовая к работе `Visual Studio 2017 Community`:

![Открытая Visual Studio](img/visual-studio.png)

_Рисунок 14 — Открытая Visual Studio_

## Дополнительно

Можете попробовать создать простое консольное приложение по уроку:

[Сложение двух чисел в Visual Studio 2013 (консольное Win32 приложение)](https://github.com/Harrix/harrix.dev-articles-2015/tree/main/add-2-num-vs-2013-console)

А в этой статье говорится как сложить два числа в оконном приложении:

[Сложение двух чисел в Visual Studio 2017 на C++ (CLR приложение)](https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-vs-2017-clr/add-2-num-vs-2017-clr.md) | [🡥](https://harrix.dev/ru/articles/2017/add-2-num-vs-2017-clr/)

Если вы хотите разрабатывать универсальные UWP приложения, то не забудьте включить режим `Режим разработчика` в параметрах Windows 10:

![Раздел «Обновление и безопасность»](img/parameters_01.png)

_Рисунок 15 — Раздел «Обновление и безопасность»_

![Вкладка «Для разработчиков»](img/parameters_02.png)

_Рисунок 16 — Вкладка «Для разработчиков»_

Также рекомендую поменять язык интерфейса на английский. Хотя ввиду хорошей многоязычной документации от Microsoft это не так критично, как в других IDE. Смена языка делается через настройки:

![Выбор настроек Visual Studio](img/lang_01.png)

_Рисунок 17 — Выбор настроек Visual Studio_

![Смена языка Visual Studio](img/lang_02.png)

_Рисунок 18 — Смена языка Visual Studio_
