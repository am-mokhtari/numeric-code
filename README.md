![Imgur](https://i.imgur.com/Yrywt79.jpg)

# Description

### This package helps you create non-guessable and non-simple numeric codes.

### *Please note that this program only creates codes up to `8` digits!*

### The numbers created by this package meet the following conditions:

- The repetition of each digit in the whole number cannot be more than twice.
  
  - For example, the number `23242` is not allowed because the digit `2` appears three times.

- Only one digit can appear twice in the whole number; the rest of the digits cannot be repeated.
  
  - For example, the number `2332` is not allowed.

- Only two consecutive digits are allowed.
  
  - For example, the numbers `232` or `234` are not allowed, but `235` is allowed.

- Consecutive numbers next to each other can appear only once in the whole number.
  
  - For example, in the number `2354`, `2` and `3` are next to each other and `4` and `5` are next to each other, which is not allowed!

----

# How to Use

### Install the package using the following command:

```shell
composer require am-mokhtari/numeric-code
```

Use the static function **generate()** and provide the desired format, like the code below:

```php
$string_code = NumericCode::generate(5);
```

The output will be something like:

> 35634

Or

```php
$string_code = NumericCode::generate(4);
```

The output will be something like:

> 3198

----

# Speed ​​Test

#### To test the execution time, create a php file and run this code:

This test generates 1000 numeric codes without failure. (100,000 have also been tested)

```php
<?php

require_once "./vendor/autoload.php";

use AmMokhtari\NumericCode\NumericCode;

$start = microtime(true);
for ($i = 0; $i < 1_000; $i++){
    try {
        NumericCode::generate(8); // Generate an 8-digit code
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . " <br>";
    }
}
$end = microtime(true);
$executionTime = $end - $start;
echo "Execution Time: " . number_format($executionTime, 6) . " seconds <br>";
```

---

----

----

# توضیحات

### این پکیج به شما کمک میکند تا کد های عددی غیرقابل حدس و غیر ساده بسازید

### *توجه کنید که این برنامه فقط تا `۸` رقم کد ایجاد می کند!*

### اعدادی که توسط این پکیج ساخته میشوند شرط های زیر را پاس میکنند:

- تعداد تکرار هر رقم در کل عدد نمیتواند بیش از دو مرتبه باشد.
  
  - مثلا عدد `۲۳۲۴۲` چون سه مرتبه عدد `۲` ظاهر شده مجاز نیست.

- فقط یک رقم میتواند در کل عدد دو مرتبه ظاهر شود و باقی ارقام مجاز به تکرار نیستند.
  
  - مثلا عدد `۲۳۳۲` مجاز نیست.

- فقط دو رقم متوالی در کنار هم مجاز هستند.
  
  - مثلا عدد `۲۳۲` یا `۲۳۴` مجاز نیستند ولی `۲۳۵` مجاز است

- اعداد متوالی در کنار هم فقط یکبار میتوانند در کل عدد ظاهر شوند
  
  - مثلا، در عدد `۲۳۵۴` چون `۲` و `۳` کنار هم و `۴` و `۵` کنار یکدیگر هستند و مجاز نیست!

---

# نحوه ی استفاده

### پکیج را با دستور زیر نصب کنید

```shell
composer require https://packagist.org/packages/am-mokhtari/numeric_code
```

از تابع استاتیک **generate()** استفاده کنید و قالب مورد نظر را به آن بدهید، مثل کد زیر:

```php
$string_code = NumericCode::generate(5);
```

خروجی چیزی شبیه به این خواهد بود:

> 35634

یا

```php
$string_code = NumericCode::generate(4);
```

خروجی چیزی شبیه به این خواهد بود:

> 3198

---

# تست سرعت

#### برای تست مدت زمان اجرا، یک فایل php ایجاد کنید و این کد را اجرا کنید:

این تست 1000 کد عددی را بدون شکست تولید می کند. (100000 هم تست شده)

```php
<?php

require_once "./vendor/autoload.php";

use AmMokhtari\NumericCode\NumericCode;

$start = microtime(true);
for ($i = 0; $i < 1_000; $i++){
    try {
        NumericCode::generate(8); // Generate an 8-digit code
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . " <br>";
    }
}
$end = microtime(true);
$executionTime = $end - $start;
echo "Execution Time: " . number_format($executionTime, 6) . " seconds <br>";
```
