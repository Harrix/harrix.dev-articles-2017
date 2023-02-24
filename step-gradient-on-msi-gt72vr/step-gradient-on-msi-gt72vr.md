---
date: 2017-02-23
categories: [it, hardware]
tags: [MSI, Ноутбук, Nvidia]
author: Anton Sergienko
author-email: anton.b.sergienko@gmail.com
license: CC BY 4.0
license-url: https://github.com/Harrix/harrix.dev/blob/main/LICENSE.md
url-src: https://github.com/Harrix/harrix.dev-blog-2017/blob/main/step-gradient-on-msi-gt72vr/step-gradient-on-msi-gt72vr.md
---

# Ступенчатый градиент на MSI GT72VR 6RD(Dominator)-090RU

Если на заглавной картинке вы видите ступенчатый градиент, то статья для вас.

Купил недавно себе новый ноутбук MSI GT72VR 6RD(Dominator)-090RU. Всем отличный, но столкнулся с проблемой, что градиенты на экране выглядят ступенчато. Проблему помогли решить только в сервисном центре MSI по email.

Вот так выглядит один и тот же кадр на старом ноутбуке Dell Inspiron 5547–8694 и на новом MSI GT72VR 6RD:

![Одна и та же картинка на разных ноутбуках](img/problem_01.jpg)

Очевидно, что проблема в неправильной глубине цвета. Но в настройках `Панели управления NVIDIA` глубину цвета не поменяешь:

![Панель управления NVIDIA](img/problem_02.png)

![Выходная глубина цвета](img/problem_03.png)

Создадим своё собственное разрешение экрана:

![Выбор кнопки «Настройка»](img/fix_01.png)

![Создание пользовательского разрешения](img/fix_02.png)

Там поменяем частоту экрана (не знаю зачем, но так сказали в MSI):

![Изменение частоты обновления](img/fix_03.png)

![Нажатие на кнопку «OK»](img/fix_04.png)

Всё. Теперь мы получили разрешение с нужной глубиной экрана и ступенчатые градиенты пропадут:

![Итоговое пользовательское разрешение](img/fix_05.png)
