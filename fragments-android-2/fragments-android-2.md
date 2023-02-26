---
date: 2017-05-14
categories: [it, programming]
tags: [Java, Android, Android Studio]
update: 2020-05-19
related-id: fragments
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-2/fragments-android-2.md
permalink: https://harrix.dev/ru/blog/2017/fragments-android-2/
lang: ru
attribution:
- {author: Google Inc., author-site: 'https://developer.android.com/license', license: CC
    BY 2.5, license-url: 'https://creativecommons.org/licenses/by/2.5/', permalink: 'https://commons.wikimedia.org/wiki/File:Android_Studio_icon.svg',
  permalink-date: 2019-06-07, name: Android Studio icon.svg}
---

# Взаимодействие между фрагментами и активностью в Android Studio. Часть 2. Простые способы

![Featured image](featured-image.svg)

Вторая часть серии статей про взаимодействие фрагментов и активности.

Все статьи цикла «Взаимодействие между фрагментами и активностью в Android Studio»:

- [Часть 1. Подготовка](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-1/fragments-android-1.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-1/ -->
- [Часть 2. Простые способы](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-2/fragments-android-2.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-2/ -->
- [Часть 3. Через интерфейсы](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-3/fragments-android-3.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-3/ -->
- [Часть 4. Через намерения](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-4/fragments-android-4.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-4/ -->
- [Часть 5. Несколько фрагментов](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-5/fragments-android-5.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-5/ -->

Предыдущая часть [Часть 1. Подготовка](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-1/fragments-android-1.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-1/ -->.

## При старте приложения отправляем информацию в фрагмент из активности

**Задача.** При запуске приложения главная активность отправляет текст `Hello, World!` в фрагмент, который отображается в в поле `textViewFragment1` фрагмента.

**Решение.** При создании фрагмента нужные данные закинем в `Bundle`, например, по ключу `text`:

```java
FragmentManager fm = getSupportFragmentManager();

Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
if (fragment == null) {
    fragment = new Fragment1();

    Bundle bundle = new Bundle();
    bundle.putString("text", "Hello, World!");
    fragment.setArguments(bundle);

    fm.beginTransaction()
            .add(R.id.fragmentContainer, fragment)
            .commit();
}
```

![Код с использованием Bundle](img/java_01.png)

_Рисунок 1 — Код с использованием Bundle_

В фрагменте в методе `onCreateView()` считываем пришедшую информацию по заданному ключу `text`:

```java
String textFromActivity = getArguments().getString("text");
textViewFragment1.setText(textFromActivity);
```

![Обработка полученных данных во фрагменте](img/java_02.png)

_Рисунок 2 — Обработка полученных данных во фрагменте_

![Результат выполнения программы](img/result_01.png)

_Рисунок 3 — Результат выполнения программы_

Но предложенное решение не самое хорошее. Почему? Активность хранит у себя информацию о ключе фрагмента. Это не хорошо. Было бы хорошо, если бы только фрагмент хранил информацию о ключе.

В фрагменте создадим **статическую** переменную `KEY`:

```java
public static final String KEY = "text";
```

![Создание статической переменной во фрагменте](img/java_03.png)

_Рисунок 4 — Создание статической переменной во фрагменте_

Теперь в активности значение ключа будем вытаскивать из фрагмента `Fragment1.KEY`:

```java
bundle.putString(Fragment1.KEY, "Hello, World!");
```

![Использование ключа в активности](img/java_04.png)

_Рисунок 5 — Использование ключа в активности_

![Результат выполнения программы](img/result_02.png)

_Рисунок 6 — Результат выполнения программы_

Приведу полные коды файлов.

---

**Полные коды файлов** <!-- !details -->

`MainActivity.java`:

```java
package com.example.fragments;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private EditText editText;
    private TextView textView;
    private Button button;
    private FrameLayout fragmentContainer;
    private FrameLayout fragmentContainer2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editText = (EditText) findViewById(R.id.editText);
        textView = (TextView) findViewById(R.id.textView);
        button = (Button) findViewById(R.id.button);
        fragmentContainer = (FrameLayout) findViewById(R.id.fragmentContainer);
        fragmentContainer2 = (FrameLayout) findViewById(R.id.fragmentContainer2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        FragmentManager fm = getSupportFragmentManager();

        Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
        if (fragment == null) {
            fragment = new Fragment1();

            Bundle bundle = new Bundle();
            bundle.putString(Fragment1.KEY, "Hello, World!");
            fragment.setArguments(bundle);

            fm.beginTransaction()
                    .add(R.id.fragmentContainer, fragment)
                    .commit();
        }
    }
}
```

`Fragment1.java`:

```java
package com.example.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class Fragment1 extends Fragment {

    private EditText editTextFragment1;
    private TextView textViewFragment1;
    private Button buttonFragment1;

    public static final String KEY = "text";

    public Fragment1() {
    }

    public static Fragment1 newInstance(String param1, String param2) {
        Fragment1 fragment = new Fragment1();
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_1, container, false);

        editTextFragment1 = (EditText) view.findViewById(R.id.editTextFragment1);
        textViewFragment1 = (TextView) view.findViewById(R.id.textViewFragment1);
        buttonFragment1 = (Button) view.findViewById(R.id.buttonFragment1);

        buttonFragment1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        String textFromActivity = getArguments().getString("text");
        textViewFragment1.setText(textFromActivity);

        return view;
    }
}
```

---

## Получаем информацию из активности в фрагменте при клике кнопки активности

**Задача.** При нажатии на кнопку `button` в главной активности текст из `editText` главной активности должен отобразится в поле `textViewFragment1` фрагмента.

**Решение.** Тут всё просто. Реализуем какой-нибудь метод во фрагменте, который будем вызвать, чтобы отправить во фрагмент информацию. Например, реализуем метод `sendData()`:

```java
public void sendData(String data) {
    if (data != null)
        textViewFragment1.setText(data);
}
```

![Метод sendData()](img/java_05.png)

_Рисунок 7 — Метод sendData()_

Теперь в клике кнопки `button` активности нам нужно найти текущий фрагмент, который находится в контейнере `fragmentContainer`:

```java
Fragment1 fragment1 = (Fragment1)getSupportFragmentManager()
        .findFragmentById(R.id.fragmentContainer);
```

А потом уже у фрагмента вызвать наш метод `sendData()`:

```java
button.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        Fragment1 fragment1 = (Fragment1)getSupportFragmentManager()
                .findFragmentById(R.id.fragmentContainer);

        if (fragment1 != null) {
            String S = editText.getText().toString();
            fragment1.sendData(S);
        }
    }
});
```

![Результат выполнения программы](img/result_03.mp4)

_Рисунок 8 — Результат выполнения программы_

---

**Полные коды файлов** <!-- !details -->

Полный код `MainActivity.java`:

```java
package com.example.fragments;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private EditText editText;
    private TextView textView;
    private Button button;
    private FrameLayout fragmentContainer;
    private FrameLayout fragmentContainer2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editText = (EditText) findViewById(R.id.editText);
        textView = (TextView) findViewById(R.id.textView);
        button = (Button) findViewById(R.id.button);
        fragmentContainer = (FrameLayout) findViewById(R.id.fragmentContainer);
        fragmentContainer2 = (FrameLayout) findViewById(R.id.fragmentContainer2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Fragment1 fragment1 = (Fragment1)getSupportFragmentManager()
                        .findFragmentById(R.id.fragmentContainer);

                if (fragment1 != null) {
                    String S = editText.getText().toString();
                    fragment1.sendData(S);
                }
            }
        });

        FragmentManager fm = getSupportFragmentManager();

        Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
        if (fragment == null) {
            fragment = new Fragment1();
            fm.beginTransaction()
                    .add(R.id.fragmentContainer, fragment)
                    .commit();
        }
    }
}
```

Полный код `Fragment1.java`:

```java
package com.example.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class Fragment1 extends Fragment {

    private EditText editTextFragment1;
    private TextView textViewFragment1;
    private Button buttonFragment1;

    public Fragment1() {
    }

    public static Fragment1 newInstance(String param1, String param2) {
        Fragment1 fragment = new Fragment1();
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_1, container, false);

        editTextFragment1 = (EditText) view.findViewById(R.id.editTextFragment1);
        textViewFragment1 = (TextView) view.findViewById(R.id.textViewFragment1);
        buttonFragment1 = (Button) view.findViewById(R.id.buttonFragment1);

        buttonFragment1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        return view;
    }

    public void sendData(String data) {
        if (data != null)
            textViewFragment1.setText(data);
    }
}
```

---

## Получаем информацию из активности в фрагменте при клике кнопки фрагмента

**Задача.** При нажатии на кнопку `buttonFragment1` в фрагменте текст из `editText` главной активности должен отобразится в поле `textViewFragment1` фрагмента.

Если в прошлый раз мы нажимали кнопку в активности, то сейчас будем нажимать в фрагменте.

В коде я откатываюсь к [точке сохранения 1](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-1/fragments-android-1.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-1/ -->.

**Решение.** Мы из фрагмента можем получить доступ к активности, где располагается данный фрагмент, через `getActivity()`. Поэтому код клика кнопки `buttonFragment1` будет таким:

```java
buttonFragment1.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        EditText editText = (EditText) getActivity().findViewById(R.id.editText);
        String S = editText.getText().toString();
        textViewFragment1.setText(S);
    }
});
```

![Результат выполнения программы](img/result_04.mp4)

_Рисунок 9 — Результат выполнения программы_

Код `MainActivity.java` не меняется.

---

**Полные коды файлов** <!-- !details -->

Полный код `MainActivity.java`. По сравнению с точкой сохранения тут ничего не поменялось:

```java
package com.example.fragments;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private EditText editText;
    private TextView textView;
    private Button button;
    private FrameLayout fragmentContainer;
    private FrameLayout fragmentContainer2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editText = (EditText) findViewById(R.id.editText);
        textView = (TextView) findViewById(R.id.textView);
        button = (Button) findViewById(R.id.button);
        fragmentContainer = (FrameLayout) findViewById(R.id.fragmentContainer);
        fragmentContainer2 = (FrameLayout) findViewById(R.id.fragmentContainer2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        FragmentManager fm = getSupportFragmentManager();

        Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
        if (fragment == null) {
            fragment = new Fragment1();
            fm.beginTransaction()
                    .add(R.id.fragmentContainer, fragment)
                    .commit();
        }
    }
}
```

Полный код `Fragment1.java`:

```java
package com.example.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class Fragment1 extends Fragment {

    private EditText editTextFragment1;
    private TextView textViewFragment1;
    private Button buttonFragment1;

    public Fragment1() {
    }

    public static Fragment1 newInstance(String param1, String param2) {
        Fragment1 fragment = new Fragment1();
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_1, container, false);

        editTextFragment1 = (EditText) view.findViewById(R.id.editTextFragment1);
        textViewFragment1 = (TextView) view.findViewById(R.id.textViewFragment1);
        buttonFragment1 = (Button) view.findViewById(R.id.buttonFragment1);

        buttonFragment1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                EditText editText = (EditText) getActivity().findViewById(R.id.editText);
                String S = editText.getText().toString();
                textViewFragment1.setText(S);
            }
        });

        return view;
    }
}
```

---

## Получаем информацию из фрагмента в активности при клике кнопки активности

**Задача.** При нажатии на кнопку `button` в активности текст из `editTextFragment1` фрагмента должен отобразится в поле `textView` активности.

В коде я откатываюсь к [точке сохранения 1](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-1/fragments-android-1.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-1/ -->.

**Решение.** Мы можем в фрагменте определить метод `getData()`, который будет возвращать значение из поля ввода:

```java
String getData() {
    return editTextFragment1.getText().toString();
}
```

![Метод getData()](img/java_06.png)

_Рисунок 10 — Метод getData()_

Теперь в активности мы можем при клике кнопки вызвать этот метод `getData()`:

```java
button.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        Fragment1 fragment1 = (Fragment1)getSupportFragmentManager()
                .findFragmentById(R.id.fragmentContainer);

        if (fragment1 != null) {
            String S = fragment1.getData();
            textView.setText(S);
        }
    }
});
```

![Метод обработки клика кнопки в активности](img/java_07.png)

_Рисунок 11 — Метод обработки клика кнопки в активности_

![Результат выполнения программы](img/result_05.mp4)

_Рисунок 12 — Результат выполнения программы_

---

**Полные коды файлов** <!-- !details -->

Файл `MainActivity.java`:

```java
package com.example.fragments;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private EditText editText;
    private TextView textView;
    private Button button;
    private FrameLayout fragmentContainer;
    private FrameLayout fragmentContainer2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editText = (EditText) findViewById(R.id.editText);
        textView = (TextView) findViewById(R.id.textView);
        button = (Button) findViewById(R.id.button);
        fragmentContainer = (FrameLayout) findViewById(R.id.fragmentContainer);
        fragmentContainer2 = (FrameLayout) findViewById(R.id.fragmentContainer2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Fragment1 fragment1 = (Fragment1)getSupportFragmentManager()
                        .findFragmentById(R.id.fragmentContainer);

                if (fragment1 != null) {
                    String S = fragment1.getData();
                    textView.setText(S);
                }
            }
        });

        FragmentManager fm = getSupportFragmentManager();

        Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
        if (fragment == null) {
            fragment = new Fragment1();
            fm.beginTransaction()
                    .add(R.id.fragmentContainer, fragment)
                    .commit();
        }
    }
}
```

Файл `Fragment1.java`:

```java
package com.example.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class Fragment1 extends Fragment {

    private EditText editTextFragment1;
    private TextView textViewFragment1;
    private Button buttonFragment1;

    public Fragment1() {
    }

    public static Fragment1 newInstance(String param1, String param2) {
        Fragment1 fragment = new Fragment1();
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_1, container, false);

        editTextFragment1 = (EditText) view.findViewById(R.id.editTextFragment1);
        textViewFragment1 = (TextView) view.findViewById(R.id.textViewFragment1);
        buttonFragment1 = (Button) view.findViewById(R.id.buttonFragment1);

        buttonFragment1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        return view;
    }

    String getData() {
        return editTextFragment1.getText().toString();
    }
}
```

---

## Получаем информацию из фрагмента в активности при клике кнопки фрагмента

**Задача.** При нажатии на кнопку `buttonFragment1` в фрагменте текст из `editTextFragment1` фрагмента должен отобразится в поле `textView` активности.

В коде я откатываюсь к [точке сохранения 1](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-1/fragments-android-1.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-1/ -->.

**Решение.** Мы из фрагмента можем получить доступ к активности, где располагается данный фрагмент, через `getActivity()`. Поэтому код клика кнопки `buttonFragment1` будет таким:

```java
buttonFragment1.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        TextView textView = (TextView) getActivity().findViewById(R.id.textView);
        String S = editTextFragment1.getText().toString();
        textView.setText(S);
    }
});
```

![Метод обработки клика кнопки фрагмента](img/java_08.png)

_Рисунок 13 — Метод обработки клика кнопки фрагмента_

![Результат выполнения программы](img/result_06.mp4)

_Рисунок 14 — Результат выполнения программы_

Код файла `MainActivity.java` не меняется.

---

**Полные коды файлов** <!-- !details -->

Файл `MainActivity.java`:

```java
package com.example.fragments;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    private EditText editText;
    private TextView textView;
    private Button button;
    private FrameLayout fragmentContainer;
    private FrameLayout fragmentContainer2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editText = (EditText) findViewById(R.id.editText);
        textView = (TextView) findViewById(R.id.textView);
        button = (Button) findViewById(R.id.button);
        fragmentContainer = (FrameLayout) findViewById(R.id.fragmentContainer);
        fragmentContainer2 = (FrameLayout) findViewById(R.id.fragmentContainer2);

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        FragmentManager fm = getSupportFragmentManager();

        Fragment fragment = fm.findFragmentById(R.id.fragmentContainer);
        if (fragment == null) {
            fragment = new Fragment1();
            fm.beginTransaction()
                    .add(R.id.fragmentContainer, fragment)
                    .commit();
        }
    }
}
```

Файл `Fragment1.java`:

```java
package com.example.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class Fragment1 extends Fragment {

    private EditText editTextFragment1;
    private TextView textViewFragment1;
    private Button buttonFragment1;

    public Fragment1() {
    }

    public static Fragment1 newInstance(String param1, String param2) {
        Fragment1 fragment = new Fragment1();
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_1, container, false);

        editTextFragment1 = (EditText) view.findViewById(R.id.editTextFragment1);
        textViewFragment1 = (TextView) view.findViewById(R.id.textViewFragment1);
        buttonFragment1 = (Button) view.findViewById(R.id.buttonFragment1);

        buttonFragment1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                TextView textView = (TextView) getActivity().findViewById(R.id.textView);
                String S = editTextFragment1.getText().toString();
                textView.setText(S);
            }
        });

        return view;
    }
}
```

---

Следующая часть [Часть 3. Через интерфейсы](https://github.com/Harrix/harrix.dev-blog-2017/blob/main/fragments-android-3/fragments-android-3.md) <!-- https://harrix.dev/ru/blog/2017/fragments-android-3/ -->.
