---
date: 2017-03-18
categories: [it, programming]
tags: [C++, Visual Studio, Сложение двух чисел]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/add-2-num-vs-2015-console-2/add-2-num-vs-2015-console-2.md
permalink: https://harrix.dev/ru/blog/2017/add-2-num-vs-2015-console-2/
lang: ru
attribution:
  - {
      author: Microsoft Corporation,
      author-site: "https://www.microsoft.com/",
      license: Public
        domain,
      license-url: "https://en.wikipedia.org/wiki/Public_domain",
      permalink: "https://commons.wikimedia.org/wiki/File:Visual_Studio_2017_Logo.svg",
      permalink-date: 2019-06-08,
      name: Visual Studio 2017 Logo.svg,
    }
---

# Сложение двух чисел в Visual Studio 2015 на C++ без использования `stdafx.h` (консольное Win32 приложение)

![Featured image](featured-image.svg)

В статье рассказывается, как создать консольное приложения сложения двух чисел Win32 в Visual Studio 2015 без `stdafx.h`.

## Создание проекта

![Создание нового проекта](img/new-project_01.jpg)

_Рисунок 1 — Создание нового проекта_

![Выбор типа проекта](img/new-project_02.jpg)

_Рисунок 2 — Выбор типа проекта_

![Мастер создания консольного приложения](img/new-project_03.jpg)

_Рисунок 3 — Мастер создания консольного приложения_

Выбираем создание пустого проекта:

![Выбор пустого проекта](img/new-project_04.jpg)

_Рисунок 4 — Выбор пустого проекта_

![Созданный пустой проект](img/new-project_05.jpg)

_Рисунок 5 — Созданный пустой проект_

## Болванка приложения C++

У нас создался пустой проект без каких-либо файлов `cpp` или `h`.

Поэтому создадим нужный нам файл. В разделе `Файлы исходного кода` щелкнем правой кнопкой и выберем команду `Добавить`, а там `Создать элемент`:

![Создание нового элемента](img/new-cpp_01.jpg)

_Рисунок 6 — Создание нового элемента_

Там создадим `cpp` файл с каким-нибудь названием:

![Создание файла C++](img/new-cpp_02.jpg)

_Рисунок 7 — Создание файла C++_

![Созданный пустой файл](img/new-cpp_03.jpg)

_Рисунок 8 — Созданный пустой файл_

В пустом файле пропишем болванку консольного приложения:

```cpp
#include <iostream>

using namespace std;

int main() {

  return 0;
}
```

![Код болванки программы](img/cpp_01.jpg)

_Рисунок 9 — Код болванки программы_

В функции `main` пропишем строчки кода, чтобы русский язык отображался корректно:

```cpp
setlocale(LC_ALL, "RUSSIAN"); // Для корректного отображения русского языка
// Раскомментировать строчки ниже, если с русским будут проблемы
// setlocale(LC_ALL, "ru_RU.UTF-8");
// setlocale(LC_ALL, "");
```

В итоге получаем болванку программы на C++, которую потом удобно использовать для других приложений учебного толка:

```cpp
#include <iostream>

using namespace std;

int main() {
  setlocale(LC_ALL, "RUSSIAN"); // Для корректного отображения русского языка
  // Раскомментировать строчки ниже, если с русским будут проблемы
  // setlocale(LC_ALL, "ru_RU.UTF-8");
  // setlocale(LC_ALL, "");

  return 0;
}
```

![Код болванки программы с добавленным кодом](img/cpp_02.jpg)

_Рисунок 10 — Код болванки программы с добавленным кодом_

## Написание кода основной программы

А теперь пропишем основной код нашей программы, где через `cin` мы считываем в переменные наши числа, а через `cout` выводим текст в консоль:

```cpp
int a, b, c;

// Считаем первое число
cout << "Введите первое число:" << endl;
cin >> a;

// Считаем второе число
cout << "Введите второе число:" << endl;
cin >> b;

// Посчитаем сумму
c = a + b;

// Выведем результат
cout << "Сумма: " << c << endl;
```

Полная программа будет выглядеть так:

```cpp
#include <iostream>

using namespace std;

int main() {
  setlocale(LC_ALL, "RUSSIAN"); // Для корректного отображения русского языка
  // Раскомментировать строчки ниже, если с русским будут проблемы
  // setlocale(LC_ALL, "ru_RU.UTF-8");
  // setlocale(LC_ALL, "");

  int a, b, c;

  // Считаем первое число
  cout << "Введите первое число:" << endl;
  cin >> a;

  // Считаем второе число
  cout << "Введите второе число:" << endl;
  cin >> b;

  // Посчитаем сумму
  c = a + b;

  // Выведем результат
  cout << "Сумма: " << c << endl;

  return 0;
}
```

## Запуск программы

![Запуск программы](img/run.jpg)

_Рисунок 11 — Запуск программы_

Получаем наше приложение:

![Запущенное приложение](img/result_01.jpg)

_Рисунок 12 — Запущенное приложение_

![Результат выполнения приложения](img/result_02.jpg)

_Рисунок 13 — Результат выполнения приложения_
