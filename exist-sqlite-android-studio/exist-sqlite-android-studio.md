---
date: 2017-04-10
categories:
  - it
  - programming
tags:
  - Android
  - Android Studio
  - Java
  - SQLite
  - Базы данных
  - SQL
update: 2020-01-20
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/exist-sqlite-android-studio/exist-sqlite-android-studio.md
permalink: https://harrix.dev/ru/articles/2017/exist-sqlite-android-studio/
lang: ru
attribution:
  - author: Google Inc.
    author-site: https://developer.android.com/license
    license: CC BY 2.5
    license-url: https://creativecommons.org/licenses/by/2.5/
    permalink: https://commons.wikimedia.org/wiki/File:Android_Studio_icon.svg
    permalink-date: 2019-06-07
    name: Android Studio icon.svg
  - author: Mike Toews
    author-site: https://commons.wikimedia.org/wiki/User:Mwtoews
    license: CC BY-SA 3.0
    license-url: https://creativecommons.org/licenses/by-sa/3.0/deed.en
    permalink: https://commons.wikimedia.org/wiki/File:Sqlite-square-icon.svg
    permalink-date: 2019-01-26
    name: Sqlite-square-icon.svg
---

# Подключение существующей БД SQLite в Android Studio

![Featured image](featured-image.svg)

Пример простого Android приложения, в котором подключаемся к заранее подготовленной базе данных SQLite.

<details>
<summary>📖 Содержание</summary>

## Содержание

- [Введение](#введение)
- [Создание базы данных](#создание-базы-данных)
- [Создание Android проекта](#создание-android-проекта)
- [Разметка активности](#разметка-активности)
- [Подготовка Java кода](#подготовка-java-кода)
- [Добавление БД в проект](#добавление-бд-в-проект)
- [Добавление класса для работы с БД](#добавление-класса-для-работы-с-бд)
- [Подключаемся к БД](#подключаемся-к-бд)
- [Работа с базой данных](#работа-с-базой-данных)
- [Обновление БД](#обновление-бд)
- [Работа с большой БД](#работа-с-большой-бд)
- [Отображение списка данных по запросу](#отображение-списка-данных-по-запросу)
- [Добавление новых записей из Android приложения](#добавление-новых-записей-из-android-приложения)

</details>

## Введение

Есть два подхода к работе с БД в Android приложениях.

В первом варианте БД создается в событии `OnCreate` главной активности. Данный вариант хорош для случая, когда база данных при установке приложения пуста либо заполнена небольшим количеством данных, а также в БД активно производятся записи в дальнейшем.

Но данный способ не очень хорош, если, например, пишите какой-нибудь справочник или другое приложение, когда БД при установке приложения уже должна быть заполнена большим количеством записей. На мой взгляд, в этом случае лучше БД подготовить заранее, а потом уже её подключить как отдельный файл в ресурсах приложения. В данной статье рассмотрен данный случай.

## Создание базы данных

Для создания БД SQLite будем использовать, например, [DB Browser for SQLite](https://sqlitebrowser.org/). Скачиваем и устанавливаем.

Буем создавать БД с одной таблицей такого вида.

| \_id | name  | age |
| ---- | ----- | --- |
| 1    | Anton | 30  |
| 2    | Alina | 24  |
| 3    | Dima  | 28  |
| 4    | Dasha | 23  |

Итак, создаем базу данных:

![Создание базы данных](img/database_01.jpg)

_Рисунок 1 — Создание базы данных_

Где-нибудь сохраняем и называем, например, `info.db`:

![Выбор имени базы данных](img/database_02.jpg)

_Рисунок 2 — Выбор имени базы данных_

Создаем таблицу, например, `clients`. И добавляем там поле:

![Создание поля в таблице](img/database_03.jpg)

_Рисунок 3 — Создание поля в таблице_

Первым полем у нас будет номер записи `_id`. Поле будет также первичным ключом:

![Выбор параметров поля](img/database_04.jpg)

_Рисунок 4 — Выбор параметров поля_

Аналогичным способом создаем поля `age` и `name`. И жмем `OK`:

![Создание других полей в базе данных](img/database_05.jpg)

_Рисунок 5 — Создание других полей в базе данных_

В списке таблиц у нас появилась наша таблица `clients`:

![Новая таблица в списке таблиц](img/database_06.jpg)

_Рисунок 6 — Новая таблица в списке таблиц_

Переходим в режим заполнения таблицы:

![Вкладка «Данные»](img/database_07.jpg)

_Рисунок 7 — Вкладка «Данные»_

Выбираем там нашу таблицу и жмем `Добавить запись`:

![Кнопка «Добавить запись»](img/database_08.jpg)

_Рисунок 8 — Кнопка «Добавить запись»_

Заполняем наши данные и сохраняем изменения в БД:

![Заполнение данных в таблицу](img/database_09.jpg)

_Рисунок 9 — Заполнение данных в таблицу_

Файл подготовленной базы данных можно взять из архива: [info.zip](files/info.zip).

## Создание Android проекта

Открываем Android Studio и создаем там новый проект с пустой активностью. Всё как обычно:

![Создание нового проекта](img/new-project_01.png)

_Рисунок 10 — Создание нового проекта_

![Выбор типа активности проекта](img/new-project_02.png)

_Рисунок 11 — Выбор типа активности проекта_

![Настройка проекта](img/new-project_03.png)

_Рисунок 12 — Настройка проекта_

![Созданный проект](img/new-project_04.png)

_Рисунок 13 — Созданный проект_

## Разметка активности

Так как мы создаем простейшее приложение, но в XML файле активности разместим только кнопку и поле для вывода текста:

![Файл разметки XML](img/xml_01.png)

_Рисунок 14 — Файл разметки XML_

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:paddingLeft="16dp"
    android:paddingRight="16dp"
    android:orientation="vertical" >

    <TextView
        android:id="@+id/textView"
        android:layout_width="match_parent"
        android:layout_height="wrap_content" />

    <Button
        android:id="@+id/button"
        android:layout_width="100dp"
        android:layout_height="wrap_content"
        android:layout_gravity="right"
        android:text="Read DB" />
</LinearLayout>
```

![Код разметки XML](img/xml_02.png)

_Рисунок 15 — Код разметки XML_

![Вид активности в режиме визуального редактирования](img/xml_03.png)

_Рисунок 16 — Вид активности в режиме визуального редактирования_

## Подготовка Java кода

Нам потребуется обработать клик на кнопку `button` и что-то записать в `textView`.

Поэтому найдем данные компоненты и свяжем их в Java коде с XML:

![Файл класса активности](img/java_01.png)

_Рисунок 17 — Файл класса активности_

Объявим переменные компонентов:

```java
Button button;
TextView textView;
```

Найдем компоненты в XML разметке:

```java
button = (Button) findViewById(R.id.button);
textView = (TextView) findViewById(R.id.textView);
```

Пропишем обработчик клика кнопки:

```java
button.setOnClickListener(new View.OnClickListener() {
   @Override
   public void onClick(View v) {
   }
});
```

Полный код Java файла (без строчки `package`, которая у вас должна быть своей):

```java
import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    // Объявим переменные компонентов
    Button button;
    TextView textView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Найдем компоненты в XML разметке
        button = (Button) findViewById(R.id.button);
        textView = (TextView) findViewById(R.id.textView);

        // Пропишем обработчик клика кнопки
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });
    }
}
```

![Код активности](img/java_02.png)

_Рисунок 18 — Код активности_

## Добавление БД в проект

Все приготовления сделаны. Теперь можем начать работать по теме статьи. Вначале добавим файл базы данных в проект.

Создадим папку `assets` в нашем проекте:

![Создание новой папки в проекте](img/assets_01.png)

_Рисунок 19 — Создание новой папки в проекте_

![Завершение создания папки](img/assets_02.png)

_Рисунок 20 — Завершение создания папки_

![Созданная папка assets](img/assets_03.png)

_Рисунок 21 — Созданная папка assets_

Скопируем файл нашей базы данных:

![Копирование файла базы данных](img/assets_04.png)

_Рисунок 22 — Копирование файла базы данных_

![Вставка файла базы данных](img/assets_05.png)

_Рисунок 23 — Вставка файла базы данных_

![Окно для изменения названия копируемого файла](img/assets_06.png)

_Рисунок 24 — Окно для изменения названия копируемого файла_

![Добавленный файл базы данных](img/assets_07.png)

_Рисунок 25 — Добавленный файл базы данных_

## Добавление класса для работы с БД

Для открытия и подготовки БД в Android используется наследник класса `SQLiteOpenHelper`. Мы тоже создадим наследник этого класса `DatabaseHelper`, но он будет сильно модифицированный, так как мы будем работать с готовой базой данных, а не создавать ей с помощью SQL запросов:

![Создание нового Java класса](img/class_01.png)

_Рисунок 26 — Создание нового Java класса_

![Ввод названия класса](img/class_02.png)

_Рисунок 27 — Ввод названия класса_

![Созданный класс](img/class_03.png)

_Рисунок 28 — Созданный класс_

Ниже приведен текст всего класса, который нужно просто скопировать (не трогая свой первой строчки `package`):

```java
import android.content.Context;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

public class DatabaseHelper extends SQLiteOpenHelper {
    private static String DB_NAME = "info.db";
    private static String DB_PATH = "";
    private static final int DB_VERSION = 1;

    private SQLiteDatabase mDataBase;
    private final Context mContext;
    private boolean mNeedUpdate = false;

    public DatabaseHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        if (android.os.Build.VERSION.SDK_INT >= 17)
            DB_PATH = context.getApplicationInfo().dataDir + "/databases/";
        else
            DB_PATH = "/data/data/" + context.getPackageName() + "/databases/";
        this.mContext = context;

        copyDataBase();

        this.getReadableDatabase();
    }

    public void updateDataBase() throws IOException {
        if (mNeedUpdate) {
            File dbFile = new File(DB_PATH + DB_NAME);
            if (dbFile.exists())
                dbFile.delete();

            copyDataBase();

            mNeedUpdate = false;
        }
    }

    private boolean checkDataBase() {
        File dbFile = new File(DB_PATH + DB_NAME);
        return dbFile.exists();
    }

    private void copyDataBase() {
        if (!checkDataBase()) {
            this.getReadableDatabase();
            this.close();
            try {
                copyDBFile();
            } catch (IOException mIOException) {
                throw new Error("ErrorCopyingDataBase");
            }
        }
    }

    private void copyDBFile() throws IOException {
        InputStream mInput = mContext.getAssets().open(DB_NAME);
        OutputStream mOutput = new FileOutputStream(DB_PATH + DB_NAME);
        byte[] mBuffer = new byte[1024];
        int mLength;
        while ((mLength = mInput.read(mBuffer)) > 0)
            mOutput.write(mBuffer, 0, mLength);
        mOutput.flush();
        mOutput.close();
        mInput.close();
    }

    public boolean openDataBase() throws SQLException {
        mDataBase = SQLiteDatabase.openDatabase(DB_PATH + DB_NAME, null, SQLiteDatabase.CREATE_IF_NECESSARY);
        return mDataBase != null;
    }

    @Override
    public synchronized void close() {
        if (mDataBase != null)
            mDataBase.close();
        super.close();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {

    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        if (newVersion > oldVersion)
            mNeedUpdate = true;
    }
}
```

Для работы в последующим с другими базами данных вам ничего не нужно будет менять в данном классе, кроме строчек:

```java
private static String DB_NAME = "info.db";
private static String DB_PATH = "";
private static final int DB_VERSION = 1;
```

![Сайт по работе с базой данных](img/class_04.png)

_Рисунок 29 — Сайт по работе с базой данных_

Разберем что означают эти строчки.

`DB_NAME` — имя файла БД. Какой файл БД вы создали, такое название сюда и копируем.

`DB_PATH` — путь к БД. Каждое приложение в Android имеет свою область памяти, куда складываются файлы программы. Вдруг вы захотите вывернуть путь к файлу БД. Я бы ничего не трогал.

`DB_VERSION` — самая интересная переменная (причем в примерах в сети по работе с готовой БД её обходят стороной). Это номер версии БД. Ниже описан принцип работы данного класса. Например, вы пишите справочник рецептов под Android и рецепты храните в БД. В момент создания установки приложения программа должна скопировать БД на устройство. Потом через какое-то время вы решили обновить приложение, и БД у вас обновилась: структура БД поменялась, добавились новые рецепты. И вам нужно заменить старую БД на новую. Вот тут вы и пропишите в данной переменной новую версию БД. И при открытии приложения будет произведена проверки версии БД, и файл БД обновится. Вначале версия БД равна 1.

Итак, логика работы класса `DatabaseHelper` в подготовке базы данных:

- Копируем файл БД, если этого файла нет (при установке приложения).

- Если номер БД обновлен, то заменяем один файл базы данных на другой:

```java
private static final int DB_VERSION = 2;
```

- После работы с базой данных из данного класса вытаскиваем экземпляр `SQLiteDatabase`, с которым будем работать в дальнейшем: осуществлять запросы и так далее.

## Подключаемся к БД

Перейдем в класс нашей активности. В нем создадим экземпляр класса `DatabaseHelper`, попытаемся обновить БД, если это требуется, а потом вытащим экземпляр `SQLiteDatabase`.

Создадим переменные в классе:

```java
// Переменная для работы с БД
private DatabaseHelper mDBHelper;
private SQLiteDatabase mDb;
```

![Объявление переменных по работе с базой данных](img/java_03.png)

_Рисунок 30 — Объявление переменных по работе с базой данных_

В методе `onCreate` выполним подготовительные действия:

```java
mDBHelper = new DatabaseHelper(this);

try {
    mDBHelper.updateDataBase();
} catch (IOException mIOException) {
    throw new Error("UnableToUpdateDatabase");
}

try {
    mDb = mDBHelper.getWritableDatabase();
} catch (SQLException mSQLException) {
    throw mSQLException;
}
```

![Инициализация переменных по работе с базой данных](img/java_04.png)

_Рисунок 31 — Инициализация переменных по работе с базой данных_

## Работа с базой данных

Теперь мы можем наконец в клике кнопки соединиться с базой данной и вытащить нужные нам данные.

Давайте при клике кнопки в `textView` отобразятся все имена учеников в строчку. Будем работать с помощью `Cursor`.

В `setOnClickListener` припишем такой, например, код:

```java
String product = "";

Cursor cursor = mDb.rawQuery("SELECT * FROM clients", null);
cursor.moveToFirst();
while (!cursor.isAfterLast()) {
    product += cursor.getString(1) + " | ";
    cursor.moveToNext();
}
cursor.close();

textView.setText(product);
```

Полный код Java файла активности у меня получился такой (без первой строчки `package`):

```java
import androidx.appcompat.app.AppCompatActivity;

import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import java.io.IOException;

public class MainActivity extends AppCompatActivity {

    // Объявим переменные компонентов
    Button button;
    TextView textView;

    // Переменная для работы с БД
    private DatabaseHelper mDBHelper;
    private SQLiteDatabase mDb;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mDBHelper = new DatabaseHelper(this);

        try {
            mDBHelper.updateDataBase();
        } catch (IOException mIOException) {
            throw new Error("UnableToUpdateDatabase");
        }

        try {
            mDb = mDBHelper.getWritableDatabase();
        } catch (SQLException mSQLException) {
            throw mSQLException;
        }

        // Найдем компоненты в XML разметке
        button = (Button) findViewById(R.id.button);
        textView = (TextView) findViewById(R.id.textView);

        // Пропишем обработчик клика кнопки
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String product = "";

                Cursor cursor = mDb.rawQuery("SELECT * FROM clients", null);
                cursor.moveToFirst();
                while (!cursor.isAfterLast()) {
                    product += cursor.getString(1) + " | ";
                    cursor.moveToNext();
                }
                cursor.close();

                textView.setText(product);
            }
        });
    }
}
```

Запустим приложение:

![Запуск приложения](img/run.png)

_Рисунок 32 — Запуск приложения_

Вот так приложение выглядит при запуске:

![Запущенное приложение](img/result_01.png)

_Рисунок 33 — Запущенное приложение_

При нажатии на кнопку получим список имен из БД:

![Результат выполнения программы](img/result_02.png)

_Рисунок 34 — Результат выполнения программы_

Фактически это всё. У нас есть экземпляр `SQLiteDatabase mDb`, с которым мы можем работать так как нам нужно. Дальше будут рассмотрены некоторые особенности работы с БД.

## Обновление БД

Откроем в программе `DB Browser for SQLite` файл БД, который располагается в папке `assets` нашей программы. И внесем какие-нибудь изменения и сохраним. Я для примера поменял имя в первой строке таблицы:

![Изменение базы данных](img/database_10.png)

_Рисунок 35 — Изменение базы данных_

Итак, в исходниках программы у нас файл БД поменялся. Запустим приложение.

И увидим, что в приложении изменения не проявились. Почему? Потому что приложение не обновляет файл БД каждый раз при запуске приложения. А вдруг вы записываете в БД какие-то записи: тогда при обновлении файла все добавленные записи сотрутся:

![Результат выполнения приложения без изменений в базе данных](img/result_03.png)

_Рисунок 36 — Результат выполнения приложения без изменений в базе данных_

Нам нужно в файле класса DatabaseHelper поменять номер версии БД в сторону увеличения:

```java
private static final int DB_VERSION = 2;
```

![Изменение номера версии базы данных](img/java_04.png)

_Рисунок 37 — Изменение номера версии базы данных_

Теперь при запуске приложения данные обновятся:

![Результат выполнения приложения с изменениями в базе данных](img/result_04.png)

_Рисунок 38 — Результат выполнения приложения с изменениями в базе данных_

Обратите внимание на то, что обновление БД произойдет только один раз. И до следующего изменения переменной `DB_VERSION` файл БД обновляться файлом из папки `assets` не будет.

**Внимание!** При обновлении БД заменяется файл БД, а, значит, все внесенные изменения в БД на приложении в Android (через запросы `INSERT`, `UPDATE`) будут удалены! Поэтому, если вам внесенные изменения нужны, то не вызывайте метод `updateDataBase`, а в методе `onUpgrade` внесите стандартным способом обновления в БД. При этом замена файла БД не будет происходить. Например, так можно вставить в таблицу новый столбец:

```java
@Override
public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
    if (newVersion > oldVersion) {
        String q = "ALTER TABLE clients ADD height INTEGER";
        db.execSQL(q);
    }
}
```

## Работа с большой БД

Когда готовил статью, то я часто встречал замечания, что файлы больше 1 Мб или 8 Мб из папки `assets` не копируются. Хотя, я пробовал работать с файлом в 14 Мб. Запускал на разных устройствах и никаких проблем не заметил.

Если что, то вот этот файл [info_large.zip](files/info_large.zip)

Но мало ли. Вдруг у вас проблемы будут замечены. В качестве решения можно размещать файл БД не папке `assets`, а в папке `res/raw`:

![Создание новой папки в папке ресурсов](img/big-db_01.png)

_Рисунок 39 — Создание новой папки в папке ресурсов_

![Ввод названия папки](img/big-db_02.png)

_Рисунок 40 — Ввод названия папки_

![Созданная папка](img/big-db_03.png)

_Рисунок 41 — Созданная папка_

И файл БД копируем в эту папку:

![Скопированный файл большой базы данных](img/big-db_04.png)

_Рисунок 42 — Скопированный файл большой базы данных_

В классе `DatabaseHelper` нам нужно поменять только одну строчку в методе `copyDBFile`.

Было:

```java
InputStream mInput = mContext.getAssets().open(DB_NAME);
```

Стало:

```java
InputStream mInput = mContext.getResources().openRawResource(R.raw.info_large);
```

Да, если вы перед этим использовали старый вариант на том устройстве, где тестируете приложение, то не забудьте поменять версию базы данных `DB_VERSION`, а то вы не увидите изменений в базе данных. Можно также удалить приложение вначале, а заново его установить.

Полный код класса (без строчки `package`):

```java
import android.content.Context;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

public class DatabaseHelper extends SQLiteOpenHelper {
    private static String DB_NAME = "info.db";
    private static String DB_PATH = "";
    private static final int DB_VERSION = 1;

    private SQLiteDatabase mDataBase;
    private final Context mContext;
    private boolean mNeedUpdate = false;

    public DatabaseHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        if (android.os.Build.VERSION.SDK_INT >= 17)
            DB_PATH = context.getApplicationInfo().dataDir + "/databases/";
        else
            DB_PATH = "/data/data/" + context.getPackageName() + "/databases/";
        this.mContext = context;

        copyDataBase();

        this.getReadableDatabase();
    }

    public void updateDataBase() throws IOException {
        if (mNeedUpdate) {
            File dbFile = new File(DB_PATH + DB_NAME);
            if (dbFile.exists())
                dbFile.delete();

            copyDataBase();

            mNeedUpdate = false;
        }
    }

    private boolean checkDataBase() {
        File dbFile = new File(DB_PATH + DB_NAME);
        return dbFile.exists();
    }

    private void copyDataBase() {
        if (!checkDataBase()) {
            this.getReadableDatabase();
            this.close();
            try {
                copyDBFile();
            } catch (IOException mIOException) {
                throw new Error("ErrorCopyingDataBase");
            }
        }
    }

    private void copyDBFile() throws IOException {
        //InputStream mInput = mContext.getAssets().open(DB_NAME);
        InputStream mInput = mContext.getResources().openRawResource(R.raw.info_large);
        OutputStream mOutput = new FileOutputStream(DB_PATH + DB_NAME);
        byte[] mBuffer = new byte[1024];
        int mLength;
        while ((mLength = mInput.read(mBuffer)) > 0)
            mOutput.write(mBuffer, 0, mLength);
        mOutput.flush();
        mOutput.close();
        mInput.close();
    }

    public boolean openDataBase() throws SQLException {
        mDataBase = SQLiteDatabase.openDatabase(DB_PATH + DB_NAME, null, SQLiteDatabase.CREATE_IF_NECESSARY);
        return mDataBase != null;
    }

    @Override
    public synchronized void close() {
        if (mDataBase != null)
            mDataBase.close();
        super.close();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {

    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        if (newVersion > oldVersion)
            mNeedUpdate = true;
    }
}
```

## Отображение списка данных по запросу

В примерах выше мы выводили информацию просто в строку в `textView`. Для демонстрации работы класса это достаточно, но чаще всего требуется данные из БД выводить списком. Напоследок приведу пример, когда на экран список людей из таблицы БД выведется не в строчку, а списком.

Делается это через обычный адаптер. Особенно не буду перегружать объяснением.

В `activity_main.xml` добавляем `ListView`:

```xml
<ListView android:id="@+id/listView"
        android:layout_width="match_parent"
        android:layout_height="match_parent" />
```

![Компонент ListView](img/xml_04.png)

_Рисунок 43 — Компонент ListView_

Создадим файл разметки `adapter_item.xml`, в котором опишем внешний вид одного элемента списка с таким содержанием:

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical" >

    <TextView android:id="@+id/textView"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Имя"
        android:textAppearance="?android:attr/textAppearanceLarge" />

    <TextView android:id="@+id/textView2"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="Возраст"
        android:textAppearance="?android:attr/textAppearanceMedium" />

</LinearLayout>
```

![Создание нового файла разметки XML](img/xml_05.png)

_Рисунок 44 — Создание нового файла разметки XML_

![Ввод названия файла разметки](img/xml_06.png)

_Рисунок 45 — Ввод названия файла разметки_

![Разметка элемента списка](img/xml_07.png)

_Рисунок 46 — Разметка элемента списка_

Добавим, например, в метод onCreate главной активности код:

```java
// Список клиентов
ArrayList<HashMap<String, Object>> clients = new ArrayList<HashMap<String, Object>>();

// Список параметров конкретного клиента
HashMap<String, Object> client;

// Отправляем запрос в БД
Cursor cursor = mDb.rawQuery("SELECT * FROM clients", null);
cursor.moveToFirst();

// Пробегаем по всем клиентам
while (!cursor.isAfterLast()) {
    client = new HashMap<String, Object>();

    // Заполняем клиента
    client.put("name",  cursor.getString(1));
    client.put("age",  cursor.getString(2));

    // Закидываем клиента в список клиентов
    clients.add(client);

    // Переходим к следующему клиенту
    cursor.moveToNext();
}
cursor.close();

// Какие параметры клиента мы будем отображать в соответствующих
// элементах из разметки adapter_item.xml
String[] from = { "name", "age"};
int[] to = { R.id.textView, R.id.textView2};

// Создаем адаптер
SimpleAdapter adapter = new SimpleAdapter(this, clients, R.layout.adapter_item, from, to);
ListView listView = (ListView) findViewById(R.id.listView);
listView.setAdapter(adapter);
```

![Код создания списка](img/java_05.png)

_Рисунок 47 — Код создания списка_

Запускаем приложение. Видим список наших клиентов:

![Результат выполнения программы](img/result_05.png)

_Рисунок 48 — Результат выполнения программы_

Помните, что запросы к БД могут быть длительными, поэтому работу с БД лучше запихивать в другой поток, например, через `ASyncTask`.

## Добавление новых записей из Android приложения

В предыдущей версии статьи многие спрашивали, а как добавлять новые записи в таблицу. Абсолютно также, как и в обычном подходе в работе с базой данных. Например, вот код добавления новой записи:

```java
String query = "INSERT INTO clients (name, age) VALUES ('Tom', '11')";
mDb.execSQL(query);
```

И полный код примера файла активности с данным кодом (без строки `package`):

```java
import androidx.appcompat.app.AppCompatActivity;

import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

public class MainActivity extends AppCompatActivity {

    // Объявим переменные компонентов
    Button button;
    TextView textView;

    // Переменная для работы с БД
    private DatabaseHelper mDBHelper;
    private SQLiteDatabase mDb;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mDBHelper = new DatabaseHelper(this);

        try {
            mDBHelper.updateDataBase();
        } catch (IOException mIOException) {
            throw new Error("UnableToUpdateDatabase");
        }

        try {
            mDb = mDBHelper.getWritableDatabase();
        } catch (SQLException mSQLException) {
            throw mSQLException;
        }

        // Найдем компоненты в XML разметке
        button = (Button) findViewById(R.id.button);
        textView = (TextView) findViewById(R.id.textView);

        // Пропишем обработчик клика кнопки
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String query = "INSERT INTO clients (name, age) VALUES ('Tom', '11')";
                mDb.execSQL(query);
                updateList();
            }
        });
        updateList();
    }

    void updateList() {
        // Список клиентов
        ArrayList<HashMap<String, Object>> clients = new ArrayList<HashMap<String, Object>>();

        // Список параметров конкретного клиента
        HashMap<String, Object> client;

        // Отправляем запрос в БД
        Cursor cursor = mDb.rawQuery("SELECT * FROM clients", null);
        cursor.moveToFirst();

        // Пробегаем по всем клиентам
        while (!cursor.isAfterLast()) {
            client = new HashMap<String, Object>();

            // Заполняем клиента
            client.put("name",  cursor.getString(1));
            client.put("age",  cursor.getString(2));

            // Закидываем клиента в список клиентов
            clients.add(client);

            // Переходим к следующему клиенту
            cursor.moveToNext();
        }
        cursor.close();

        // Какие параметры клиента мы будем отображать в соответствующих
        // элементах из разметки adapter_item.xml
        String[] from = { "name", "age"};
        int[] to = { R.id.textView, R.id.textView2};

        // Создаем адаптер
        SimpleAdapter adapter = new SimpleAdapter(this, clients, R.layout.adapter_item, from, to);
        ListView listView = (ListView) findViewById(R.id.listView);
        listView.setAdapter(adapter);
    }
}
```

Но я крайне не рекомендую добавлять новые записи в таблицу из-под Android приложения, если база данных представлена в виде файла. Так как если вы потом обновите файл базы данных в другой версии вашего приложения, то пользователь потеряет все свои данные. Либо пропишите бэкап пользовательских записей, либо используете для них вторую базу данных, созданную стандартным способом.
