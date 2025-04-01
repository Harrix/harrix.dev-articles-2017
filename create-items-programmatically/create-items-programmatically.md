---
date: 2017-07-02
categories:
  - it
  - programming
tags:
  - Android
  - Android Studio
  - Java
update: 2019-11-03
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/create-items-programmatically/create-items-programmatically.md
permalink: https://harrix.dev/ru/articles/2017/create-items-programmatically/
lang: ru
attribution:
  - author: Google Inc.
    author-site: https://developer.android.com/license
    license: CC BY 2.5
    license-url: https://creativecommons.org/licenses/by/2.5/
    permalink: https://commons.wikimedia.org/wiki/File:Android_Studio_icon.svg
    permalink-date: 2019-06-07
    name: Android Studio icon.svg
---

# Создание элементов в Android приложении программно

![Featured image](featured-image.svg)

Иногда в приложении, описанного через XML разметку нужно создавать новые элементы программно. В статье приведен пример такого приложения.

<details>
<summary>📖 Содержание</summary>

## Содержание

- [Задача](#задача)
- [Решение](#решение)
- [Усложненный пример](#усложненный-пример)

</details>

## Задача

В окне приложения есть одна кнопка, при нажатии на которую должна появляться еще одна кнопка. При нажатии на новые кнопки они должны удаляться.

## Решение

XML разметка:

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:id="@+id/linearLayout"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:paddingLeft="16dp"
    android:paddingRight="16dp"
    android:orientation="vertical" >

    <Button
        android:id="@+id/button"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Добавить кнопку" />
</LinearLayout>
```

Java код активности (строчку `package` не копируйте, а свою в коде не удаляйте):

```java
package org.harrix.buttoncreatebutton;

import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;

public class MainActivity extends AppCompatActivity {

    private Button button;
    private LinearLayout linearLayout;

    private final int USERID = 6000;
    private int countID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        button = (Button) findViewById(R.id.button);
        linearLayout = (LinearLayout) findViewById(R.id.linearLayout);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Button b = new Button(getApplicationContext());
                b.setText("Удалить данную кнопку №" + Integer.toString(countID + 1));
                b.setLayoutParams(
                        new LinearLayout.LayoutParams(
                                LinearLayout.LayoutParams.MATCH_PARENT,
                                LinearLayout.LayoutParams.WRAP_CONTENT)
                );
                b.setId(USERID + countID);
                b.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        linearLayout.removeView(v);
                    }
                });
                linearLayout.addView(b);
                countID++;
            }
        });
    }
}
```

Получим вот это:

![Итоговый результат](img/result_01.avif)

_Рисунок 1 — Итоговый результат_

Если строчку `linearLayout.addView(b);` поменять на `linearLayout.addView(b,0);`, то элементы будут добавляться сверху.

## Усложненный пример

В коде ниже при нажатию на главную кнопку создается горизонтальный `LinearLayout`, внутри которого создается по две кнопки, при нажатии на которые они удаляются.

XML разметка:

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:id="@+id/linearLayout"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:paddingLeft="16dp"
    android:paddingRight="16dp"
    android:orientation="vertical" >

    <Button
        android:id="@+id/button"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Добавить кнопки" />
</LinearLayout>
```

Java код активности (строчку `package` не копируйте, а свою в коде не удаляйте):

```java
package org.harrix.buttoncreatebutton;

import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.LinearLayout;

public class MainActivity extends AppCompatActivity {

    private Button button;
    private LinearLayout linearLayout;

    private final int USERID = 6000;
    private int countID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        button = (Button) findViewById(R.id.button);
        linearLayout = (LinearLayout) findViewById(R.id.linearLayout);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Горизонтальный LinearLayout
                final LinearLayout subLayout = new LinearLayout(getApplicationContext());
                subLayout.setLayoutParams(new LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT,
                        LinearLayout.LayoutParams.WRAP_CONTENT)
                );
                subLayout.setOrientation(LinearLayout.HORIZONTAL);
                linearLayout.addView(subLayout);

                // Первая кнопка
                Button b = new Button(getApplicationContext());
                b.setText("Удалить данную кнопку №" + Integer.toString(countID + 1));
                b.setLayoutParams(new LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT,
                        LinearLayout.LayoutParams.WRAP_CONTENT,
                        1.f)
                );
                b.setId(USERID + countID);
                b.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        subLayout.removeView(v);
                    }
                });
                subLayout.addView(b);
                countID++;

                // Вторая кнопка
                Button b2 = new Button(getApplicationContext());
                b2.setText("Удалить данную кнопку №" + Integer.toString(countID + 1));
                b2.setLayoutParams(new LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT,
                        LinearLayout.LayoutParams.WRAP_CONTENT,
                        1.f)
                );
                b2.setId(USERID + countID);
                b2.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        subLayout.removeView(v);
                    }
                });
                subLayout.addView(b2);
                countID++;
            }
        });
    }
}
```

Получим вот это:

![Итоговый результат](img/result_02.avif)

_Рисунок 2 — Итоговый результат_
