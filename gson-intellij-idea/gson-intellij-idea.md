---
date: 2017-05-09
categories: [it, program]
tags: [JSON, IntelliJ IDEA, JetBrains, Java]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/gson-intellij-idea/gson-intellij-idea.md
permalink: https://harrix.dev/ru/blog/2017/gson-intellij-idea/
lang: ru
---

# Подключение Gson в IntelliJ IDEA и простейшая работа с библиотекой

![Featured image](featured-image.svg)

Gson — популярная [библиотека](https://github.com/google/gson) от Google для создания и парсинга JSON файлов на Java. Как подключить?

## Создание консольного приложения

Покажу на примере консольного приложения.

---

**Создание консольного приложения в IntelliJ IDEA** <!-- !details -->

![Создание нового проекта](img/new-project_01.png)

_Рисунок 1 — Создание нового проекта_

![Выбор типа нового проекта и версии JDK](img/new-project_02.png)

_Рисунок 2 — Выбор типа нового проекта и версии JDK_

![Выбор шаблона проекта](img/new-project_03.png)

_Рисунок 3 — Выбор шаблона проекта_

![Выбор имени проекта, его пакета, а также его расположения](img/new-project_04.png)

_Рисунок 4 — Выбор имени проекта, его пакета, а также его расположения_

![Созданный проект](img/new-project_05.png)

_Рисунок 5 — Созданный проект_

---

## Подключение Gson

![Выбор Project Structure](img/add-library_01.png)

_Рисунок 6 — Выбор Project Structure_

![Добавление новой библиотеки через Maven](img/add-library_02.png)

_Рисунок 7 — Добавление новой библиотеки через Maven_

Вводим `Gson` и ищем:

![Поиск библиотеки Gson](img/add-library_03.png)

_Рисунок 8 — Поиск библиотеки Gson_

В списке находим последнюю версию библиотеки:

![Выбор версии библиотеки](img/add-library_04.png)

_Рисунок 9 — Выбор версии библиотеки_

![Подтверждаем добавление библиотеки](img/add-library_05.png)

_Рисунок 10 — Подтверждаем добавление библиотеки_

![Настройка конфигурации библиотеки](img/add-library_06.png)

_Рисунок 11 — Настройка конфигурации библиотеки_

Поставьте галочку:

![Подключение библиотеки в наш проект](img/add-library_07.png)

_Рисунок 12 — Подключение библиотеки в наш проект_

Библиотека добавилась в проект:

![Добавленная библиотека в проект](img/add-library_08.png)

_Рисунок 13 — Добавленная библиотека в проект_

### Проверка работы

Код программы:

```java
package com.company;

import java.util.ArrayList;
import java.util.List;

import com.google.gson.*;

class User {
    String name;
    int age;
    List<String> programmingLanguages;

    @Override
    public String toString() {
        return "User{" +
                "name='" + name + '\'' +
                ", age=" + age +
                ", programmingLanguages=" + programmingLanguages +
                '}';
    }
}

public class Main {

    public static void main(String[] args) {
        // Создаем экземпляр пользователя
        User user = new User();
        user.name = "Anton";
        user.age = 30;
        user.programmingLanguages = new ArrayList<>();
        user.programmingLanguages.add("Java");
        user.programmingLanguages.add("C++");
        user.programmingLanguages.add("PHP");
        user.programmingLanguages.add("LaTeX");

        // Создаем экземпляр Gson
        Gson gson = new Gson();

        // Сериализуем пользователя в JSON и выведем в консоль
        String JSON = gson.toJson(user);
        System.out.println(JSON);

        // Создадим экземпляр второго пользователя на основе строки JSON
        User userTwo = gson.fromJson(JSON, User.class);
        System.out.println(userTwo);
    }
}
```

![Результат выполнения программы](img/result.png)

_Рисунок 14 — Результат выполнения программы_
