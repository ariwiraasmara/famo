# Famo
Famo adalah sebuah aplikasi berbasis Social Media dimana para pengguna dapat menambahkan anggota dan keanggotaan mereka berbasis organisasi, dengannya mereka dapat melihat dan mengetahui anggota keanggotaannya dan anggota anggotanya

### How To Run
1. Install database terlebih dahulu, yakni buat sebuah database mysql dengan nama "familyorganization"
2. Buka sebuah terminal atau command prompt, lalu eksekusi perintah ini `php artisan migrate`
3. Buka sebuah terminal atau command prompt, lalu eksekusi perintah ini `npm start`, untuk menjalankan Frontend dan ReactJS
4. Buka sebuah terminal atau command prompt, lalu eksekusi perintah ini `php artisan serve`, untuk menjalankan Backend dan Laravel
5. Jika Anda hanya membutuhkan menjalankan API-nya saja, maka jalankan instruksi nomor 4

### API Route and Instruction
Bisa menggunakan Postman atau tools sejenisnya
```
- Route (POST) http://127.0.0.1:{port}/api/user/login
- Route (GET) http://127.0.0.1:{port}/api/user/logout
- Route (POST) http://127.0.0.1:{port}/api/user/create
- Route (GET) http://127.0.0.1:{port}/api/user/find/{id}/{term} => {term} adalah nilai string
- Route (GET) http://127.0.0.1:{port}/api/user/file/all/{id}
- Route (GET) http://127.0.0.1:{port}/api/user/file/{id}
- Route (POST) http://127.0.0.1:{port}/api/user/file/store
- Route (DELETE) http://127.0.0.1:{port}/api/user/file/delete/{id}
- Route (GET) http://127.0.0.1:{port}/api/member/confirmation/all/{id}
- Route (POST) http://127.0.0.1:{port}/api/member/confirmation/store/
- Route (POST) http://127.0.0.1:{port}/api/member/confirmation/update/
- Route (POST) http://127.0.0.1:{port}/api/member/confirmation/reject/
- Route (DELETE) http://127.0.0.1:{port}/api/member/confirmation/delete/{id}
- Route (DELETE) http://127.0.0.1:{port}/api/member/confirmation/delete/all/{id}
- Route (GET) http://127.0.0.1:{port}/api/member/all/{id}
- Route (GET) http://127.0.0.1:{port}/api/member/recent/{id}
- Route (GET) http://127.0.0.1:{port}/api/member/total/{id}
- Route (GET) http://127.0.0.1:{port}/api/member/all/{id}/{order}/{by}
- Route (DELETE) http://127.0.0.1:{port}/api/member/delete/{id}
- Route (GET) http://127.0.0.1:{port}/api/membership/all/{id}
- Route (GET) http://127.0.0.1:{port}/api/membership/recent/{id}
- Route (GET) http://127.0.0.1:{port}/api/membership/total/{id}
- Route (DELETE) http://127.0.0.1:{port}/api/membership/delete/{id}
```

## Library Used
- React Redux (https://react-redux.js.org/)
- Sweetalert2 (https://sweetalert2.github.io/)
- MillionJS (https://million.dev/)
<!-- Strictus (https://github.com/php-strictus/strictus) -->
<!-- Spatie (https://github.com/spatie/laravel-csp) -->
<!-- DOMPurify (https://github.com/cure53/DOMPurify) -->

# Thanks To
- Gitlab (https://gitlab.com), as version control
- MySQL (https://www.mysql.com/), as database
- Laravel (https://laravel.com/), as backend framework
- ReactJS (https://react.dev/), as frontend framework
- BulmaCSS (https://bulma.io/), as UI and CSS Framework
- Redis (https://redis.io//), as caching memory

# @ Copyright ***Syahri Ramadhan Wiraasmara (ARI)***
