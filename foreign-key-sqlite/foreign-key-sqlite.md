---
date: 2017-06-10
categories: [it, programming]
tags: [SQLite, Базы данных, SQL]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/foreign-key-sqlite/foreign-key-sqlite.md
url: https://harrix.dev/ru/blog/2017/foreign-key-sqlite/
---

# Внешние ключи в DB Browser for SQLite

Сказ о том, как включить поддержку внешних ключей в популярной программе по редактированию SQLite баз данных.

Откроем программу `DB Browser for SQLite`.

Создадим новую базу данных, например, `music.db`:

![Создание новой базы данных](img/new-database_01.png)

Не будем пока создавать таблицы:

![Отказ от создания таблицы](img/new-database_02.png)

Включим поддержку внешних ключей. Не забудьте нажать на кнопку `Save`:

![Включение поддержки внешних ключей](img/support-foreign-key.png)

Теперь покажем, как работают внешние ключи.

Создадим две таблицы `artists` (музыканты) и `tracks` (песни). Конструктор не будем использовать. Во второй таблице будем хранить номер музыканта как внешний ключ:

```sql
CREATE TABLE artists(
  _id    INTEGER PRIMARY KEY AUTOINCREMENT,
  name  TEXT
);

CREATE TABLE tracks(
  _id     INTEGER PRIMARY KEY AUTOINCREMENT,
  title   TEXT,
  id_artist INTEGER,
  FOREIGN KEY(id_artist) REFERENCES artists(_id)
);
```

![Запуск SQL скрипта](img/sql_01.png)

![Созданные таблицы](img/table_01.png)

Опять же без конструктора закинем две записи о двух исполнителях:

```sql
INSERT INTO artists (name) VALUES ('Nightwish');
INSERT INTO artists (name) VALUES ('Scooter');
```

![Запуск SQL скрипта](img/sql_02.png)

![Созданные записи в таблицу](img/table_02.png)

Попробуем добавить записи к таблице песню с правильным номером исполнителя:

```sql
INSERT INTO tracks (title, id_artist) VALUES ('Wishmaster', 1);
```

Запрос прошел успешно:

![Запуск SQL скрипта по вставке новой записи](img/sql_03.png)

А теперь попробуем добавить запись с несуществующим номером исполнителя:

```sql
INSERT INTO tracks (title, id_artist) VALUES ('To the Sky', 100);
```

А теперь запрос не пройдет из-за внешнего ключа:

![Ошибка при выполнении SQL скрипта](img/sql_04.png)

И в таблице `tracks` мы увидим только одну запись:

![Записи в таблице](img/table_03.png)

Обратите внимание на то, что в `SQLite` можно добавлять внешние ключи через `CREATE`. В «полноценных» БД можно добавлять внешние ключи через `ALTER`. Но в SQLite это сделать [нельзя](https://stackoverflow.com/questions/1884818/how-do-i-add-a-foreign-key-to-an-existing-sqlite-table):

```sql
ALTER TABLE child ADD CONSTRAINT fk_child_parent
                  FOREIGN KEY (parent_id)
                  REFERENCES parent(id);
```

И напоследок покажу, как сделать выборку песен из БД так, чтобы вместо номеров песен мы видели названия самих исполнителей.

Этот пример стандартного вызова `SELECT`, когда мы увидим песни с номерами исполнителей:

```sql
SELECT * FROM TRACKS;
```

![Результат работы команды SELECT](img/select_01.png)

А вот пример кода, который вернет нам то, что нужно:

```sql
SELECT t._id, t.title, a.name AS a_name
FROM tracks t
LEFT JOIN artists a ON t.id_artist = a._id;
```

![Результат работы команды SELECT](img/select_02.png)

Более упрощенный код запроса:

```sql
SELECT tracks._id, tracks.title, artists.name
FROM tracks
LEFT JOIN artists ON tracks.id_artist = artists._id;
```

![Результат работы команды SELECT](img/select_03.png)

Рекомендую прочитать [эту](http://www.skillz.ru/dev/php/article-Obyasnenie_SQL_obedinenii_JOIN_INNER_OUTER.html) статью.
