# mini_erp_api (Backend)

**mini_erp_api**, küçük ve orta ölçekli işletmeler için geliştirilen  
**Laravel tabanlı, modüler ve yetkilendirme odaklı bir ERP Backend API**’sidir.

Proje; görev yönetimi, departman yapısı, kullanıcı yetkilendirme,  
aktivite loglama ve ölçeklenebilir mimari prensipleri üzerine kurulmuştur.

> Frontend (React / Next.js) ayrı bir repository olarak geliştirilmektedir.



## 🚀 Teknolojiler

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Sanctum (Token-based Authentication)
- Policy & Middleware bazlı yetkilendirme
- Queue / Job (Async işlemler)
- Observer & Activity Log (Audit Trail)



## 🔐 Kimlik Doğrulama & Yetkilendirme

- Laravel Sanctum ile token bazlı authentication
- Rol tabanlı yetkilendirme (Admin / User)
- Laravel Policy ile kaynak bazlı erişim kontrolü
- Middleware + Policy birlikte kullanımı

### Roller
- **Admin**
  - Tüm kaynaklara erişim
  - Görev, departman ve kullanıcı yönetimi
- **User**
  - Sadece kendisine atanmış görevleri görüntüleme ve güncelleme


## 📦 Modüller

### 🧩 Görev (Task) Yönetimi
- Görev oluşturma / güncelleme / silme
- Kullanıcıya görev atama
- Durum yönetimi (`todo`, `doing`, `done`)
- Policy bazlı erişim kontrolü
- Service layer ile ayrılmış iş mantığı

### 🧩 Departman Yönetimi
- Departman CRUD
- Kullanıcı–departman ilişkisi
- Departman yöneticisi kavramı
- Yetkilendirme & loglama desteği

### 🧩 Activity Log (Audit Trail)
- Kim, neyi, ne zaman yaptı?
- Task & Department işlemleri otomatik loglanır
- Observer + Service mimarisi
- Admin için log listeleme API’si

### 🧩 Import (Async)
- Excel / CSV üzerinden görev import
- Queue + Job altyapısı
- Büyük dosyalar için non-blocking yapı


## 📡 API Endpoint Özetleri

### Auth
| Method | Endpoint | Açıklama |
|------|---------|---------|
| POST | `/login` | Kullanıcı girişi |
| POST | `/logout` | Oturum kapatma |
| GET | `/me` | Oturumdaki kullanıcı bilgisi |

### Task
| Method | Endpoint | Açıklama | Yetki |
|------|---------|---------|------|
| GET | `/tasks` | Görev listesi | Auth |
| POST | `/tasks` | Görev oluştur | Admin |
| PUT | `/tasks/{id}` | Görev güncelle | Yetkili |
| PATCH | `/tasks/{id}/status` | Durum güncelle | Yetkili |

### Department
| Method | Endpoint | Açıklama | Yetki |
|------|---------|---------|------|
| GET | `/departments` | Departman listesi | Auth |
| POST | `/departments` | Departman oluştur | Admin |
| PUT | `/departments/{id}` | Departman güncelle | Admin / Manager |

### Activity Logs
| Method | Endpoint | Açıklama | Yetki |
|------|---------|---------|------|
| GET | `/activity-logs` | Sistem logları | Admin |


## 🧱 Mimari Prensipler

- Controller → **sadece yönlendirme**
- Business logic → **Service Layer**
- Validation → **Form Request**
- Yetkilendirme → **Policy**
- Loglama → **Observer + Service**
- Async işlemler → **Queue / Job**

Bu yapı, projenin ölçeklenebilir ve sürdürülebilir olmasını sağlar.


## ⚙️ Kurulum

```bash
git clone https://github.com/zynpnd/mini_erp_api.git
cd mini_erp_api

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan serve
