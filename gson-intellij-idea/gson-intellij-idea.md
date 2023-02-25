---
date: 2017-05-09
categories: [it, program]
tags: [JSON, IntelliJ IDEA, JetBrains, Java]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/gson-intellij-idea/gson-intellij-idea.md
url: https://harrix.dev/ru/blog/2017/gson-intellij-idea/
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

![Выбор типа нового проекта и версии JDK](img/new-project_02.png)

![Выбор шаблона проекта](img/new-project_03.png)

![Выбор имени проекта, его пакета, а также его расположения](img/new-project_04.png)

![Созданный проект](img/new-project_05.png)

---

## Подключение Gson

![Выбор Project Structure](img/add-library_01.png)

![Добавление новой библиотеки через Maven](img/add-library_02.png)

Вводим `Gson` и ищем:

![Поиск библиотеки Gson](img/add-library_03.png)

В списке находим последнюю версию библиотеки:

![Выбор версии библиотеки](img/add-library_04.png)

![Подтверждаем добавление библиотеки](img/add-library_05.png)

![Настройка конфигурации библиотеки](img/add-library_06.png)

Поставьте галочку:

![Подключение библиотеки в наш проект](img/add-library_07.png)

Библиотека добавилась в проект:

![Добавленная библиотека в проект](img/add-library_08.png)

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
