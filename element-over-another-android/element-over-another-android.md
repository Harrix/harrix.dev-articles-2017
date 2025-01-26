---
date: 2017-04-17
categories:
  - it
  - programming
tags:
  - Android
  - Android Studio
  - Java
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
permalink-source: https://github.com/Harrix/harrix.dev-articles-2017/blob/main/element-over-another-android/element-over-another-android.md
permalink: https://harrix.dev/ru/articles/2017/element-over-another-android/
lang: ru
---

# Разместить один элемент над другим в Android разметке

![Featured image](featured-image.svg)

Один элемент в Android разметке (картинка) растянута на весь экран. Как разместить другой элемент над ним (например, по центру).

Можно использовать, например, `RelativeLayout`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent" >

    <ImageView
        android:id="@+id/imageView"
        android:layout_width="match_parent"
        android:layout_height="match_parent"
        app:srcCompat="@android:color/holo_blue_bright" />

    <ImageView
        android:id="@+id/imageView2"
        android:layout_width="50dp"
        android:layout_height="50dp"
        app:srcCompat="@android:color/holo_blue_dark"
        android:layout_centerHorizontal="true"
        android:layout_centerVertical="true"/>

</RelativeLayout>
```

![Итоговый результат](img/result.png)

_Рисунок 1 — Итоговый результат_
