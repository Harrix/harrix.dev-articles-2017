---
date: 2017-05-07
categories: [it, programming]
tags: [C++, Qt]
update: 2020-05-12
source: files/boost.zip
---

# Установка Boost под Qt

Сказ о том, как установить библиотеку Boost для Qt под MinGW и Qt под Visual Studio.

Материал подготовлен на примере Qt 15.0, Visual Studio 2019 16.5.4, Boost 1.73.0, Windows 10. Папка Boost после компиляции под MinGW x86-x64, Visual Studio x86-x64 у меня занимает 22,9 ГБ.

## Подготовка

На сайте <https://www.boost.org/> скачиваем последнюю версию библиотеки Boost:

![Главная страница библиотеки](img/download_01.png)

![Архив последней версии библиотеки](img/download_02.png)

Распакуем архив куда-нибудь и переименуем папку в `boost`. Я распаковал в корень диска `C:\boost`:

![Файлы из распаковываемого архива](img/files.png)

## Работаем с Qt

Собираем библиотеку Boost тем компилятором, которым компилируем наши проекты, где будем использовать Boost.

**Под каждый компилятор вам нужно собирать библиотеку отдельно!**

Для Qt под `MinGW` 32 бита нам потребуется программа `gcc.exe`.

У меня этот файл находится в папке:

```console
D:\Qt\Tools\mingw730_32\bin
```

На время добавим этот путь в системную переменную `Path` на примере Windows 10:

![Переходим в настройки компьютера](img/path_01.png)

![Выбор пункта «Дополнительные параметры системы»](img/path_02.png)

![Выбора пункта «Переменные среды»](img/path_03.png)

![Выбор системной переменной Path](img/path_04.png)

![Добавление нового пути в переменной Path](img/path_05.png)

![Соглашение с изменением через нажатие кнопки «OK»](img/path_06.png)

![Соглашение с изменением через нажатие кнопки «OK»](img/path_07.png)

## Сборка для Qt под MinGW 32 бита

Вызываем командную строку. Это сделать можно разными способами. Например, жмем `Win` + `R`. Там вводим `cmd` и жмем `Enter`.

А можно через поиск:

![Вызов командной строки](img/cmd_01.png)

Вводим команду для перехода в папку, где располагается распакованный Boost:

```console
cd C:\boost
```

![Переход в папку с распакованным Boost](img/cmd_02.png)

Вводим следующую команду. И ждем, когда всё выполнится:

```console
bootstrap.bat gcc
```

![Результат выполнения команды bootstrap.bat gcc](img/cmd_03.png)

Вы библиотеку Boost возможно будете собирать под разные версии компиляторов на одном компе. Поэтому в следующей команде укажите название папки, которая создаться в папке `C:\boost`, куда будут закинуты собранные файлы. Для MinGW 32bit папку назвал `boost_mingw730_32`.

Вводим команду (не забудьте поменять название папки на вашу версию компилятора). И ждем, когда всё выполнится (а вот это будет не быстро):

```console
b2 toolset=gcc link=shared --prefix=boost_mingw730_32 install
```

И через долгое время (у меня ушло более 20 минут) библиотека соберется:

![Результат компилирования библиотеки](img/cmd_04.png)

Кстати, эту команду можно ускорить, указав параметр `-j8`, где число будет обозначать на скольких ядрах процессора будет происходить компилирование (правда у меня не сильно скорость увеличилась):

```console
b2 toolset=gcc link=shared -j8 --prefix=boost_mingw730_32 install
```

Итак, у нас у меня в папке `C:\boost\boost_mingw730_32` собранная библиотека, которую я теперь могу использовать.

Не забудьте удалить путь к `gcc.exe` из переменной `Path`. Если вы не удалите, то ничего страшного не случится, но в будущем, когда под другой компилятор или другой версии текущего компилятора будете собирать Boost, возникнут проблемы.

И вам нужно удалить только один путь из переменной Path. Не вздумайте удалить всю переменную Path! Это приведет к **очень плохим** последствиям:

![Удаление пути к компилятору](img/path_08.png)

Закрываем cmd.

## Сборка для Qt под MinGW 64 бита

Для MinGW 64 бит повторяем всё тоже самое, но указываем другой путь к компилятору (у меня это `D:\Qt\Tools\mingw730_64\bin`) и указываем другую папку для сборки (например, `boost_mingw730_64`).

После указания пути к компилятору в переменной в `Path` в консоли последовательно вызываем команды:

```console
cd C:\boost
bootstrap.bat gcc
b2 toolset=gcc link=shared --prefix=boost_mingw730_64 install
```

![Результат компилирования библиотеки](img/cmd_05.png)

Не забудьте удалить путь к `gcc.exe` из переменной `Path`.

## Сборка для Qt под Visual Studio 32 бит

И если сборка под MinGW прошла без проволочек, то со сборкой под Visual Studio я намучился.

У меня стоит сразу две версии Qt: под MinGW и под Visual Studio (`QWebEngine` работает только под Visual Studio).

Тут вместо `gcc.exe` будет нужен файл `cl.exe`. У меня стоит Visual Studio 2019, и данный файл находится в папке:

```console
C:\Program Files (x86)\Microsoft Visual Studio\2019\Community\VC\Tools\MSVC\14.25.28610\bin\Hostx86\x86\
```

Добавляем этот путь **временно** в системную переменную `Path`.

Также нам потребуется знание версии компилятора Visual Studio. Она не совпадает с названием установленной Visual Studio! Получить это значение можно из Visual Studio Installer:

![Visual Studio Installer](img/visual-studio_01.png)

Через поиск `msvc` находим установленный компилятор:

![Найденный компонент](img/visual-studio_02.png)

Нам потребуется как значение `v142`. Последовательно в cmd вызываем команды:

```console
cd C:\boost
bootstrap.bat vc142
b2 toolset=msvc-14.2 --build-type=complete --prefix=boost_vs2019_32 install
```

Обратите внимание, что в командах используется значение `v142` дважды в `vc142` и `msvc-14.2`. И не забываем поменять название папки для собранной библиотеки Boost:

![Результат выполнения команды bootstrap.bat vc142](img/cmd_06.png)

![Результат выполнения сборки](img/cmd_07.png)

## Сборка для Qt под Visual Studio 64 бита

Для MinGW повторяем всё тоже самое, но указываем другой путь к компилятору и указываем другую папку для сборки (например, `boost_vs2019_64`), а также указываем, что собираем именно под x64 (`--address-model=64`). У меня компилятор под x64 располагается тут:

```console
C:\Program Files (x86)\Microsoft Visual Studio\2019\Community\VC\Tools\MSVC\14.25.28610\bin\Hostx64\x64
```

После указания пути к компилятору в переменной в Path в консоли последовательно вызываем команды:

```console
cd C:\boost
bootstrap.bat vc142
b2 toolset=msvc-14.2 --build-type=complete --address-model=64 --prefix=boost_vs2019_64 install
```

![Результат выполнения сборки](img/cmd_08.png)

## Подготовка Qt проекта

Создадим простой проект с виджетами с кнопкой `PushButton` и полем для вывода текста `TextEdit`. Для тех, кто не знает — скриншоты по под спойлером:

---

**Создание проекта** <!-- !details -->

![Создание нового проекта](img/new-project_01.png)

![Выбор Qt Widgets Application](img/new-project_02.png)

![Выбор имени проекта и его расположения](img/new-project_03.png)

![Выбор системы сборки](img/new-project_04.png)

![Выбор названия главного класса приложения](img/new-project_05.png)

![Настройка перевода приложения](img/new-project_06.png)

![Выбор компиляторов сборки](img/new-project_07.png)

![Настройка системы контроля версий проекта](img/new-project_08.png)

![Переход на форму приложения](img/new-project_09.png)

![Размещение компонентов на форме](img/new-project_10.png)

![Переход на обработчик клика кнопки](img/new-project_11.png)

![Выбор типа события кнопки](img/new-project_12.png)

![Метод обработки клика кнопки](img/new-project_13.png)

---

## Подготовка для работы с MinGW 32 бита

Идем в файл проекта `.pro`:

![Файл проекта](img/pro_01.png)

Там подключите Boost библиотеку (не забудьте поменять пути на свои). В коде ниже есть раздел как для MinGW, так и под Visual Studio, причем под две битности x86 и x64:

```ini
greaterThan(QT_MAJOR_VERSION, 4) {
    TARGET_ARCH=$${QT_ARCH}
} else {
    TARGET_ARCH=$${QMAKE_HOST.arch}
}

contains(TARGET_ARCH, x86_64) {
    ARCHITECTURE = x64
} else {
    ARCHITECTURE = x86
}

win32-g++:contains(ARCHITECTURE, x86): {
    INCLUDEPATH += C:/boost/boost_mingw730_32/include/boost-1_73
}
win32-g++:contains(ARCHITECTURE, x64): {
    INCLUDEPATH += C:/boost/boost_mingw730_64/include/boost-1_73
}
win32-msvc*:contains(ARCHITECTURE, x86) {
    INCLUDEPATH += C:/boost/boost_vs2019_32/include/boost-1_73
}
win32-msvc*:contains(ARCHITECTURE, x64) {
    INCLUDEPATH += C:/boost/boost_vs2019_64/include/boost-1_73
}
```

![Файл проекта с подключением Boost](img/pro_02.png)

Обратите внимание на то, в какую сторону повернуты слэши.

Пути к папкам поменяйте на свои:

![Пути к скомпилированным версиям Boost](img/pro_03.png)

В дальнейшем вам нужно будет добавлять тут еще библиотеки, которые вы будете использовать. Подключаете их через `LIBS`.

Если вы не подключите их, то будете видеть подобные ошибки (по ошибкам и определяете, какие файлы нужно подключить):

![Ошибка подключения файла библиотеки Boost](img/error_01.png)

Для примеров ниже мне нужно было добавить библиотеки, и полный кусок добавляемого кода в `*.pro` файл выглядит так:

```ini
greaterThan(QT_MAJOR_VERSION, 4) {
    TARGET_ARCH=$${QT_ARCH}
} else {
    TARGET_ARCH=$${QMAKE_HOST.arch}
}

contains(TARGET_ARCH, x86_64) {
    ARCHITECTURE = x64
} else {
    ARCHITECTURE = x86
}

win32-g++:contains(ARCHITECTURE, x86): {
    INCLUDEPATH += C:/boost/boost_mingw730_32/include/boost-1_73
    LIBS += "-LC:/boost/boost_mingw730_32/lib" \
            -llibboost_date_time-mgw7-mt-x32-1_73 \
            -llibboost_system-mgw7-mt-x32-1_73
}

win32-g++:contains(ARCHITECTURE, x64): {
    INCLUDEPATH += C:/boost/boost_mingw730_64/include/boost-1_73
    LIBS += "-LC:/boost/boost_mingw730_64/lib" \
            -llibboost_date_time-mgw7-mt-x64-1_73 \
            -llibboost_system-mgw7-mt-x64-1_73
}

win32-msvc*:contains(ARCHITECTURE, x86) {
    INCLUDEPATH += C:/boost/boost_vs2019_32/include/boost-1_73
    LIBS += "-LC:/boost/boost_vs2019_32/lib" \
            -llibboost_date_time-vc142-mt-x32-1_73 \
            -llibboost_system-vc142-mt-x32-1_73
}

win32-msvc*:contains(ARCHITECTURE, x64) {
    INCLUDEPATH += C:/boost/boost_vs2019_64/include/boost-1_73
    LIBS += "-LC:/boost/boost_vs2019_64/lib" \
            -llibboost_date_time-vc142-mt-x64-1_73 \
            -llibboost_system-vc142-mt-x64-1_73
}
```

![Подключение библиотеки Boost](img/pro_04.png)

Обратите внимание, что перед путями и названием библиотеки появляется `-L` или `-l`:

![Пути к файлам Boost](img/pro_05.png)

Если вам нужно подключить несколько библиотек, то добавляете их подобным образом:

Обратите внимание на то, что для разных компиляторов одна и та же библиотека, например, `libboost_date_time` хранится в разных файлах, например с названием (без расширения) `libboost_date_time-mgw7-mt-x32-1_73` и `libboost_date_time-vc142-mt-x32-1_73`.

Если после внесения изменений и сохранения файла у вас кнопка запуска проекта горит зеленым, то всё прошло хорошо. Если серым, то где-то напортачили:

![Кнопка запуска приложения](img/run.png)

Перейдем в файл `mainwindow.cpp`:

![Файл mainwindow.cpp](img/mainwindow.png)

## Проверка № 1

Выведем седьмое простое число через функцию `prime()`. [Функция](https://www.boost.org/doc/libs/1_73_0/libs/math/doc/html/math_toolkit/number_series/primes.html) является одной из специальных математических функций.

Подключаем заголовочный файл и соответствующее пространство имен:

```cpp
#include <boost/math/special_functions/prime.hpp>
using namespace boost::math;
```

Теперь в коде клика кнопки можем прописать:

```cpp
// Седьмое простое число
boost::uint32_t k = prime(7);
ui->textEdit->insertPlainText(QString::number(k) + "\n");
```

![Результат выполнения программы](img/result_01.png)

Если возникнет такая ошибка, то повторно запустите процесс компиляции программы:

![Ошибка при компиляции программы](img/error_02.png)

## Проверка № 2

Проверим сколько дней прошло с 1 января.

Подключаем заголовочный файл и соответствующее пространство имен:

```cpp
#include <boost/date_time/gregorian/gregorian.hpp>
using namespace boost::gregorian;
```

Теперь в коде клика кнопки можем прописать:

```cpp
// Сколько дней прошло с 1 января
date today = day_clock::local_day();
partial_date new_years_day(1,Jan);
days days_since_year_start = today - new_years_day.get_date(today.year());

ui->textEdit->insertPlainText(QString::number(days_since_year_start.days()) + "\n");
```

![Результат выполнения программы](img/result_02.png)

Полный код:

```cpp
#include "mainwindow.h"
#include "ui_mainwindow.h"

#include <boost/math/special_functions/prime.hpp>
#include <boost/date_time/gregorian/gregorian.hpp>

using namespace boost::math;
using namespace boost::gregorian;

MainWindow::MainWindow(QWidget *parent)
  : QMainWindow(parent)
  , ui(new Ui::MainWindow)
{
  ui->setupUi(this);
}

MainWindow::~MainWindow()
{
  delete ui;
}


void MainWindow::on_pushButton_clicked()
{
  // Седьмое простое число
  boost::uint32_t k = prime(7);
  ui->textEdit->insertPlainText(QString::number(k) + "\n");

  // Сколько дней прошло с 1 января
  date today = day_clock::local_day();
  partial_date new_years_day(1,Jan);
  days days_since_year_start = today - new_years_day.get_date(today.year());
  ui->textEdit->insertPlainText(QString::number(days_since_year_start.days()) + "\n");
}
```

Исходники проекта прикреплены к статье.
