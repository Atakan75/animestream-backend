# Anime Streaming Platform - Laravel API

Bu proje, anime içeriklerini barındıran bir izleme platformunun backend (API) tarafını temsil eder. Laravel kullanılarak geliştirilen bu sistem, kullanıcı kimlik doğrulaması, içerik yönetimi ve güvenli veri saklama işlevlerini sunar.

## 🚀 Özellikler

- Laravel 11 ile geliştirildi
- Laravel Sanctum ile kullanıcı kimlik doğrulama
- JSON tabanlı RESTful API
- HLS video bağlantısı desteği
- Rol bazlı erişim kontrolü (Admin/Kullanıcı)
- Güvenli veri yönetimi ve validasyon
- MySQL ile ilişkisel veri yönetimi

## 💠 Kurulum

```bash
git clone https://github.com/kullanici-adi/anime-backend.git
cd anime-backend
composer install
cp .env.example .env
php artisan key:generate
```

`.env` dosyasını düzenleyin:

```env
DB_DATABASE=anime_stream
DB_USERNAME=root
DB_PASSWORD=secret
```

```bash
php artisan migrate --seed
php artisan serve
```

## 🔐 API Kimlik Doğrulama

- Sanctum token tabanlı doğrulama
- Login, register, logout endpointleri
- Kullanıcı oturumu, token ile yönetilir

## 📁 API Endpoint Örnekleri

| Yöntem | Route                | Açıklama              |
|--------|----------------------|------------------------|
| POST   | /api/register        | Kullanıcı kayıt        |
| POST   | /api/login           | Giriş                  |
| GET    | /api/anime           | Tüm animeleri listele |
| GET    | /api/anime/{id}      | Anime detayları       |

## 📄 Lisans

MIT License

