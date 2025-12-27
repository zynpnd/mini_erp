# mini_erp (Backend)

Mini ERP, küçük ve orta ölçekli işletmeler için geliştirilen  
**Laravel tabanlı bir İş / Operasyon Yönetim Paneli API**’sidir.

Frontend (React / Next.js) proje **ayrı bir repository** olarak geliştirilecektir.

---

## 🚀 Teknolojiler

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Sanctum (Token Based Auth)
- Role & Middleware bazlı yetkilendirme

---

## 🔐 Kimlik Doğrulama & Yetkilendirme

- Laravel Sanctum ile token bazlı authentication
- Role sistemi (Admin / User)
- Route ve Policy seviyesinde yetki kontrolleri

---

## 📦 MODÜL 1: Operasyon / Görev Yönetimi

### 🎯 Amaç
- Admin görev oluşturur
- Görevler kullanıcılara atanır
- Kullanıcılar sadece **kendilerine atanmış görevleri** görebilir
- Görev durumları takip edilir

---

### 📋 Özellikler
- Departman bazlı görevler
- Görev durumları:
  - `todo`
  - `doing`
  - `done`

**Admin**
- Tüm görevleri görüntüleyebilir
- Görev oluşturabilir
- Görevleri güncelleyebilir

**User**
- Sadece kendisine atanmış görevleri görür
- Kendi görevlerinin durumunu günceller

---

### 🔐 Authorization
- Task işlemleri Laravel Policy ile korunmaktadır.
- Admin tüm görevlerde yetkilidir.
- User sadece kendisine atanmış görevleri görebilir ve güncelleyebilir.


---

## 📡 API Yapısı (Özet)

| Method | Endpoint | Açıklama | Yetki |
|------|---------|---------|------|
| POST | /login | Kullanıcı girişi | Public |
| GET | /tasks | Görev listesi | Auth |
| POST | /tasks | Görev oluşturma | Admin |
| PUT | /tasks/{id} | Görev güncelleme | Auth |

---

## 🛠 Planlanan Modüller

- Department CRUD
- Kullanıcı Yönetimi
- Kanban Görev Yönetimi
- Aktivite Logları
- Raporlama & Analiz

---

## 🛠 Testler

- Test altyapısı ilerleyen aşamalarda eklenecektir.
- (Pest / PHPUnit)


---

## ⚙️ Kurulum

```bash
git clone https://github.com/zynpnd/mini_erp_api.git
cd mini_erp_api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve


