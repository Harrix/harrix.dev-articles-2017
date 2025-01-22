---
date: 2017-03-19
categories: [it, programming]
tags: [C++, Android, Сложение двух чисел]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/add-2-num-cpp-droid/add-2-num-cpp-droid.md
permalink: https://harrix.dev/ru/articles/2017/add-2-num-cpp-droid/
lang: ru
---

# Сложение двух чисел в CppDroid на C++

![Featured image](featured-image.svg)

В статье рассказывается, как создать консольное приложения сложения двух чисел в CppDroid на Android.

- [Программа](#программа)
- [Болванка приложения](#болванка-приложения)
- [Написание кода](#написание-кода)

## Программа

Программировать под C++ можно и в Android. CppDroid одна из таких приложений. Вот ссылка на приложение:

[Google Play](https://play.google.com/store/apps/details?id=name.antonsmirnov.android.cppdroid&hl=ru)

При открытии приложения будет произведена скачка и установка нужных файлов:

![Установка новых файлов](img/install.png)

_Рисунок 1 — Установка новых файлов_

После этого откроется главное окно приложения:

![Окно программы](img/cpp-droid.png)

_Рисунок 2 — Окно программы_

## Болванка приложения

Введем в редакторе вот такой код:

```cpp
#include <iostream>
using namespace std;
int main(){

return 0;
}
```

![Код болванки](img/code_01.png)

_Рисунок 3 — Код болванки_

Сохраните и скомпилируйте приложение:

![Компилирование проекта](img/run_01.jpg)

_Рисунок 4 — Компилирование проекта_

![Завершение компилирования](img/run_02.png)

_Рисунок 5 — Завершение компилирования_

После этого запустите приложение:

![Запуск приложения](img/run_03.jpg)

_Рисунок 6 — Запуск приложения_

Откроется пустое окно. Если вы его видите, то всё хорошо:

![Запущенная болванка приложения](img/result_01.png)

_Рисунок 7 — Запущенная болванка приложения_

## Написание кода

Внутри функции `main` напишем такой код:

```cpp
int a, b, c;
cout << "Input first number:"<< endl;
cin >> a;
cout << "Input second number:"<< endl;
cin >> b;
c = a + b;
cout << "Sum = " << c;
return 0;
```

Полный код будет такой:

```cpp
#include <iostream>
using namespace std;
int main(){
int a, b, c;
cout << "Input first number:"<< endl;
cin >> a;
cout << "Input second number:"<< endl;
cin >> b;
c = a + b;
cout << "Sum = " << c;
return 0;
}
```

![Код программы](img/code_02.png)

_Рисунок 8 — Код программы_

Аналогичным способом выше сохраним, скомпилируем и запустим программу:

![Компилирование программы](img/run_04.png)

_Рисунок 9 — Компилирование программы_

![Запущенное приложение](img/result_02.png)

_Рисунок 10 — Запущенное приложение_

Введите числа и получите в результате:

![Результат выполнения программы](img/result_03.png)

_Рисунок 11 — Результат выполнения программы_
