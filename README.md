### Laravel Application To Parse Data From Different Providers

---

#### Installation

requirements :
- PHP 8.1

after clone this repo, you should run this commands in your terminal inside project directory

```
composer install
```

then copy `` .env.example `` file and rename to `` .env `` and generate application key by run

```
php artisan key:generate 
```

run ``` php artisan serve ``` to start application server

using postman or any other tool like it visit http://127.0.0.1:8000/api/v1/users and you will see the  results.
can filter using 
 - provider
 - statusCode
 - balanceMin
 - balanceMax
 - currency

can run tests using ``` php artisan test --filter=UserControllerTest ```

