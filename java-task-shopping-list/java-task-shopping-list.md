---
date: 2017-04-10
categories: [it, programming]
tags: [Java, Task]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
---

# Задача на Java: Список покупок

В статье рассматривается решение одной из задач на тему структур данных по курсу Java.

## Задача

Вы должны написать полностью программу на `Java`: необходимые директивы `import`, один `public` класс с именем `Main` в пакете по умолчанию (в коде отсутствует подстрока `package`) с функцией `main()`), которая решает задачу.

Ввод осуществляется с консоли, вывод — на консоль.

Программа должна работать точно по протоколу, который показан в примерах.

Например, нельзя выводить ничего лишнего, скажем, фразу «Введите N».

Дана база данных о продажах некоторого интернет-магазина. Каждая строка входного файла представляет собой запись вида:

```text
Покупатель товар количество
```

Здесь `Покупатель` — имя покупателя (строка без пробелов), `товар` — название товара (строка без пробелов), `количество` — количество приобретенных единиц товара.

Создайте список всех покупателей, а для каждого покупателя подсчитайте количество приобретенных им единиц каждого вида товаров.

### Входные данные

Вводятся сведения о покупках в указанном формате.

### Выходные данные

Выведите список всех покупателей в лексикографическом порядке, после имени каждого покупателя выведите двоеточие, затем выведите список названий всех приобретенных данным покупателем товаров в лексикографическом порядке, после названия каждого товара выведите количество единиц товара, приобретенных данным покупателем. Информация о каждом товаре выводится в отдельной строке.

### Пример входных данных

```text
Ivanov paper 10
Petrov pens 5
Ivanov marker 3
Ivanov paper 7
Petrov envelope 20
Ivanov envelope 5
```

### Пример выходных данных

```text
Ivanov:
envelope 5
marker 3
paper 17
Petrov:
envelope 20
pens 5
```

### Пример входных данных 2

```text
Ivanov aaa 1
Petrov aaa 2
Sidorov aaa 3
Ivanov aaa 6
Petrov aaa 7
Sidorov aaa 8
Ivanov bbb 3
Petrov bbb 7
Sidorov aaa 345
Ivanov ccc 45
Petrov ddd 34
Ziborov eee 234
Ivanov aaa 45
```

### Пример выходных данных 2

```text
Ivanov:
aaa 52
bbb 3
ccc 45
Petrov:
aaa 9
bbb 7
ddd 34
Sidorov:
aaa 356
Ziborov:
eee 234
```

## Считывание входных данных

Создадим консольное пустое приложение в Java:

```java
public class Main {

    public static void main(String[] args) {
    // write your code here
    }
}
```

Вначале разберемся со считыванием информации. Как видим, из условий, данные нам приходят построчно. И в каждой строчке через пробел располагается три параметра. Логично считывать данные через `Scanner` с помощью `nextLine()`, а потом считанную строчку разделить на кусочки по пробелу.

В качестве остановки считывания можно использовать команду `hasNext()`.

Правда возникнет проблема. Если на экземпляр `Scanner` подавать данные из файла, то с помощью `hasNext()` дойдем до символа `EOF` в конце файла и прекратим считывание строк. С консолью такое не прокатит. Поэтому для проверки работы программы в консоли эмулируем завершение цикла через ввод строки `exit`.

Итак, данный код позволяет считывать строчки до появления символа `EOF` или до ввода `exit`:

```java
public class Main {

    public static void main(String[] args) {
        Scanner sc = new Scanner (System.in);

        while(sc.hasNext()) {
            String s = sc.nextLine();
            if(s.equals("exit")) {
                break;
            }
        }

    }
}
```

Теперь с помощью команды `split()` разобьем строчку на составные части и запишем в три переменные наши значения:

```java
public class Main {

    public static void main(String[] args) {
        Scanner sc = new Scanner (System.in);

        while(sc.hasNext()) {
            String s = sc.nextLine();
            if(s.equals("exit")) {
                break;
            }

            String[] parts = s.split(" ");

            String name = parts[0];
            String productName = parts[1];
            Integer count = Integer.parseInt(parts[2]);
        }

    }
}
```

Теперь мы на каждой итерации цикла знаем содержимое нужных нам переменных.

## Сохраняем данные в структуре данных

Данная задача относится к курсу про структуры данных, поэтому их и будем использовать. Каждый покупатель имеет уникальное имя. Каждому покупателю соответствует список товаров. Причем и покупатели, и товары должны быть отсортированы в алфавитном порядке.

Сюда напрашивается использование множества `Set` или карты `Map`. Приведу пример с использованием карты `Map`. Как мы знаем, в Java карта `Map` — это всего лишь интерфейс. Поэтому нужно будет либо создавать свой класс, либо использовать существующий. Наиболее известны из готовых `HashMap` (на основе хэш-значений ключей) и `TreeMap` (внутри строится дерево элементов по ключам).

По условию данные должны быть отсортированы, и этому требованию соответствует `TreeMap`.

В качестве ключа в карте было бы логично использовать имя покупателя. А что можно выбрать в виде значения в карте? Каждому покупателю соответствует список товаров. Так пусть в качестве значения в нашей карте будет выступать другая карта, которая будет хранить в качестве ключа название товара, а в качестве значения — его количество.

Получим в итоге вот такую карту:

```java
TreeMap<String, TreeMap<String, Integer>> clients = new TreeMap<String, TreeMap <String, Integer>>();
```

Кусок кода с закидыванием информации в данное дерево я опишу в виде комментариев в коде:

```java
// Если клиента с таким именем нет в карте, то мы закинем нового покупателя
// с пустой картой покупок
if (!clients.containsKey(name))
    clients.put(name, new TreeMap <String, Integer>());

// Сейчас в карте точно содержится покупатель с именем name
// Для удобства вытащим данного покупателя в отдельную переменную
TreeMap <String, Integer> temp = clients.get(name);

// Если у покупателя нет товара с наименованием productName, то закинем такой товар
// с количеством покупок равное 0
if (!temp.containsKey(productName))
    temp.put(productName,0);

// Теперь у покупателя точно есть товар с наименованием productName
// Вытащим текущее количество данного товара
Integer oldCount = temp.get(productName);

// Заменим значение товара с его количеством на новое значение
temp.put(productName, oldCount + count);
```

Получим:

```java
import java.util.Scanner;
import java.util.TreeMap;

public class Main {

    public static void main(String[] args) {
        // Карта покупателей с картой покупок покупателя
        TreeMap<String, TreeMap<String, Integer>> clients = new TreeMap<String, TreeMap <String, Integer>>();

        Scanner sc = new Scanner (System.in);

        // Считываем строчки, пока можем
        while(sc.hasNext()) {
            String s = sc.nextLine();

            // Имитация завершения считывания строчек
            if(s.equals("exit")) {
                break;
            }

            // Считанную строчку делим на части
            String[] parts = s.split(" ");

            // Части строчек раскидываем по переменным
            String name = parts[0];
            String productName = parts[1];
            Integer count = Integer.parseInt(parts[2]);

            // Если клиента с таким именем нет в карте, то мы закинем нового покупателя
            // с пустой картой покупок
            if (!clients.containsKey(name))
                clients.put(name, new TreeMap <String, Integer>());

            // Сейчас в карте точно содержится покупатель с именем name
            // Для удобства вытащим данного покупателя в отдельную переменную
            TreeMap <String, Integer> temp = clients.get(name);

            // Если у покупателя нет товара с наименованием productName, то закинем такой товар
            // с количеством покупок равное 0
            if (!temp.containsKey(productName))
                temp.put(productName,0);

            // Теперь у покупателя точно есть товар с наименованием productName
            // Вытащим текущее количество данного товара
            Integer oldCount = temp.get(productName);

            // Заменим значение товара с его количеством на новое значение
            temp.put(productName, oldCount + count);
        }

    }
}
```

Проверяем наличие записи по ключу в карте через `containsKey()`.

Помним, что в записи `TreeMap <String, Integer> temp = clients.get(name);` переменная `temp` хранит ссылку на элемент карты. И изменения в данной переменной приведут к изменениям в элементе карты. Что нам и надо.

И обратите внимание на строчку `temp.put(productName, oldCount + count);`. Мы знаем, что в карте товаров точно есть запись с ключом `productName`. Нам нужно значение элемента с этим ключом поменять на новое. Напрямую это не получится сделать. Но мы помним, что есть в карту добавить элемент с существующим уже ключом, то мы перепишем значение элемента с данным ключом. Чем мы воспользовались в данной строчке.

## Вывод результата на экран

Фактически после заполнения карты `clients` в этой карте мы имеем все наши данные в нужном порядке. Есть клиенты, отсортированные в алфавитном порядке. В каждом клиенте (покупателе) есть отсортированный массив товаров, причем товары не повторяются, а повторы по количеству товаров сложились друг с другом. Остается только вывести результат.

Будем использовать `foreach`. Обратите внимание, что с картой данный цикл имеет специфический вид.

Например, для `TreeMap<String,Integer>` получим следующий цикл:

```java
for(Map.Entry<String,Integer> entry : treeMap.entrySet()) {
  String key = entry.getKey();
  Integer value = entry.getValue();

  System.out.println(key + " => " + value);
}
```

По аналогии сделаем цикл для прохода нашей карты:

```java
for(Map.Entry<String, TreeMap <String, Integer>> entry : clients.entrySet()) {
    String key = entry.getKey();
    TreeMap <String, Integer> value = entry.getValue();

    System.out.println(key + ":");
}
```

Этот цикл выведет имена покупателей и знак двоеточия. Теперь нужно внутри каждой итерации цикла вывести список товаров. Там у нас также карта, так что действуем по аналогии:

```java
for(Map.Entry<String, TreeMap <String, Integer>> entry : clients.entrySet()) {
    String key = entry.getKey();
    TreeMap <String, Integer> value = entry.getValue();

    System.out.println(key + ":");

    for(Map.Entry<String,Integer> product : value.entrySet()) {
        String keyProduct = product.getKey();
        Integer valueProduct = product.getValue();

        System.out.println(keyProduct + " " + valueProduct);
    }
}
```

Всё задача решена.

## Полный код решения задачи

Приведем теперь окончательный код программы:

```java
package com.example;

import java.util.Map;
import java.util.Scanner;
import java.util.TreeMap;

public class Main {

    public static void main(String[] args) {
        // Карта покупателей с картой покупок покупателя
        TreeMap<String, TreeMap<String, Integer>> clients = new TreeMap<String, TreeMap <String, Integer>>();

        Scanner sc = new Scanner (System.in);

        // Считываем строчки, пока можем
        while(sc.hasNext()) {
            String s = sc.nextLine();

            // Имитация завершения считывания строчек
            if(s.equals("exit")) {
                break;
            }

            // Считанную строчку делим на части
            String[] parts = s.split(" ");

            // Части строчек раскидываем по переменным
            String name = parts[0];
            String productName = parts[1];
            Integer count = Integer.parseInt(parts[2]);

            // Если клиента с таким именем нет в карте, то мы закинем нового покупателя
            // с пустой картой покупок
            if (!clients.containsKey(name))
                clients.put(name, new TreeMap <String, Integer>());

            // Сейчас в карте точно содержится покупатель с именем name
            // Для удобства вытащим данного покупателя в отдельную переменную
            TreeMap <String, Integer> temp = clients.get(name);

            // Если у покупателя нет товара с наименованием productName, то закинем такой товар
            // с количеством покупок равное 0
            if (!temp.containsKey(productName))
                temp.put(productName,0);

            // Теперь у покупателя точно есть товар с наименованием productName
            // Вытащим текущее количество данного товара
            Integer oldCount = temp.get(productName);

            // Заменим значение товара с его количеством на новое значение
            temp.put(productName, oldCount + count);
        }

        // Выведем наши данные из карты в нужном формате
        for(Map.Entry<String, TreeMap <String, Integer>> entry : clients.entrySet()) {
            String key = entry.getKey();
            TreeMap <String, Integer> value = entry.getValue();

            // Выводим имя покупателя
            System.out.println(key + ":");

            // Выводим вторым циклом список товаров с их количеством
            for(Map.Entry<String,Integer> product : value.entrySet()) {
                String keyProduct = product.getKey();
                Integer valueProduct = product.getValue();

                System.out.println(keyProduct + " " + valueProduct);
            }
        }
    }
}
```

Для тестирующей системы удаляем строчку `package` и все комментарии (так как содержат кириллицу):

```java
import java.util.Map;
import java.util.Scanner;
import java.util.TreeMap;

public class Main {

    public static void main(String[] args) {
        TreeMap<String, TreeMap<String, Integer>> clients = new TreeMap<String, TreeMap <String, Integer>>();

        Scanner sc = new Scanner (System.in);

        while(sc.hasNext()) {
            String s = sc.nextLine();

            if(s.equals("exit")) {
                break;
            }

            String[] parts = s.split(" ");

            String name = parts[0];
            String productName = parts[1];
            Integer count = Integer.parseInt(parts[2]);

            if (!clients.containsKey(name))
                clients.put(name, new TreeMap <String, Integer>());

            TreeMap <String, Integer> temp = clients.get(name);

            if (!temp.containsKey(productName))
                temp.put(productName,0);

            Integer oldCount = temp.get(productName);

            temp.put(productName, oldCount + count);
        }

        for(Map.Entry<String, TreeMap <String, Integer>> entry : clients.entrySet()) {
            String key = entry.getKey();
            TreeMap <String, Integer> value = entry.getValue();

            System.out.println(key + ":");

            for(Map.Entry<String,Integer> product : value.entrySet()) {
                String keyProduct = product.getKey();
                Integer valueProduct = product.getValue();

                System.out.println(keyProduct + " " + valueProduct);
            }
        }
    }
}
```
