## ⚙️ Setup Instructions

1. **Clone the repository**

```bash
git clone git@github.com:Irfan-Chowdhury/Sellora.git

cd Sellora
````

2. **Install dependencies**

```bash
composer install

cp .env.example .env

php artisan key:generate
```

3. **Configure `.env`**

Update your database, mail, queue connection and other credentials.

4. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

5. **Run the app**

```bash
php artisan serve
```
> The API will now be available at http://127.0.0.1:8000

6. **Testing by PEST (Optional)**

```bash
php artisan test
```
---