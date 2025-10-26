# 🚀 دليل رفع التحديثات على السيرفر

## 📋 المحتويات

1. [التحضير](#التحضير)
2. [الاتصال بالسيرفر](#الاتصال-بالسيرفر)
3. [سحب التحديثات من GitHub](#سحب-التحديثات-من-github)
4. [تحديث Database](#تحديث-database)
5. [إضافة API Key](#إضافة-api-key)
6. [تحديث Dependencies](#تحديث-dependencies)
7. [مسح Cache](#مسح-cache)
8. [ضبط الصلاحيات](#ضبط-الصلاحيات)
9. [اختبار الموقع](#اختبار-الموقع)
10. [استكشاف الأخطاء](#استكشاف-الأخطاء)

---

## 🎯 التحضير

### تأكد من وجود هذه المعلومات:

```
✅ عنوان السيرفر (IP أو Domain)
✅ اسم المستخدم (username)
✅ كلمة السر أو SSH Key
✅ مسار المشروع على السيرفر
✅ API Key من Google Gemini
```

---

## 🔌 الاتصال بالسيرفر

### الطريقة 1: عبر SSH من Terminal

```bash
# اتصل بالسيرفر
ssh username@your-server.com

# أو إذا كان عندك IP مباشر:
ssh username@123.456.789.0

# أو إذا عندك port مخصص:
ssh -p 2222 username@your-server.com
```

### الطريقة 2: عبر cPanel Terminal

```
1. سجل دخول على cPanel
2. اذهب إلى "Terminal" أو "SSH Access"
3. افتح Terminal
```

### الطريقة 3: عبر Putty (Windows)

```
1. حمّل Putty من: https://www.putty.org/
2. افتح Putty
3. ضع IP السيرفر
4. اضغط "Open"
5. أدخل username و password
```

---

## 📥 سحب التحديثات من GitHub

### الخطوة 1: الانتقال لمجلد المشروع

```bash
# انتقل لمجلد المشروع (غيّر المسار حسب سيرفرك)
cd /home/username/public_html

# أو
cd /var/www/html

# أو
cd ~/portfolio
```

### الخطوة 2: التحقق من الـ Branch الحالي

```bash
# شوف أنت على أي branch
git branch

# يجب أن ترى: * main
```

### الخطوة 3: سحب آخر التحديثات

```bash
# احفظ أي تعديلات محلية (إذا موجودة)
git stash

# سحب التحديثات من GitHub
git pull origin main

# أو إذا كان عندك تعديلات محلية تريد دمجها:
git pull origin main --rebase
```

### إذا ظهرت رسالة Conflict:

```bash
# شوف الملفات المتعارضة
git status

# اختر طريقة الحل:

# 1. إذا تريد تحديثات GitHub (الموصى به):
git checkout --theirs filename.php
git add filename.php

# 2. أو إذا تريد تبقي التعديلات المحلية:
git checkout --ours filename.php
git add filename.php

# بعد حل كل التعارضات:
git rebase --continue

# أو إذا تريد إلغاء العملية:
git rebase --abort
```

---

## 🗄️ تحديث Database

### الخطوة 1: تشغيل Migrations الجديدة

```bash
# تشغيل migrations
php artisan migrate

# إذا ظهر خطأ، جرب:
php artisan migrate --force
```

### الخطوة 2: التحقق من الـ Tables الجديدة

```bash
# دخول لـ MySQL
mysql -u username -p database_name

# داخل MySQL:
SHOW TABLES;

# شوف table articles:
DESCRIBE articles;

# يجب أن ترى الأعمدة الجديدة:
# - show_toc
# - toc_mode
# - toc_content

# خروج من MySQL:
EXIT;
```

---

## 🔑 إضافة API Key

### الخطوة 1: تحرير ملف `.env`

```bash
# افتح .env بمحرر نصوص
nano .env

# أو
vim .env

# أو
vi .env
```

### الخطوة 2: إضافة API Key

في نهاية الملف، أضف:

```env
# Google Gemini AI
GEMINI_API_KEY=AIzaSyBdXO451ymiZMjdjDZ4jH9qHHL52_Y-688
```

**⚠️ مهم:** استبدل المفتاح بمفتاحك الحقيقي!

### الخطوة 3: حفظ وإغلاق

```bash
# في nano:
# اضغط Ctrl+O للحفظ
# اضغط Enter
# اضغط Ctrl+X للخروج

# في vim/vi:
# اضغط ESC
# اكتب :wq
# اضغط Enter
```

### الخطوة 4: التحقق

```bash
# تحقق أن المفتاح موجود
grep GEMINI .env
```

---

## 📦 تحديث Dependencies

### تحديث Composer Packages (إذا كان في تحديثات)

```bash
# تحديث packages
composer install --no-dev --optimize-autoloader

# أو إذا كان composer.lock متغير:
composer update --no-dev --optimize-autoloader
```

### تحديث NPM Packages (إذا كان في تحديثات)

```bash
# تحديث packages
npm install

# إعادة build الـ assets
npm run build

# أو للـ production:
npm run production
```

---

## 🧹 مسح Cache

### مسح كل أنواع الـ Cache

```bash
# مسح config cache
php artisan config:clear

# مسح route cache
php artisan route:clear

# مسح view cache
php artisan view:clear

# مسح application cache
php artisan cache:clear

# مسح compiled classes
php artisan clear-compiled

# إعادة بناء config cache (اختياري - للأداء)
php artisan config:cache

# إعادة بناء route cache (اختياري - للأداء)
php artisan route:cache
```

### مسح Cache متقدم

```bash
# مسح كل شيء دفعة واحدة
php artisan optimize:clear

# ثم إعادة تحسين (للـ production):
php artisan optimize
```

---

## 🔐 ضبط الصلاحيات

### صلاحيات المجلدات والملفات

```bash
# العودة لمجلد المشروع
cd /path/to/your/project

# ضبط صلاحيات storage
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# ضبط صلاحيات public (للملفات الجديدة)
chmod -R 755 public/css
chmod -R 755 public/js

# ضبط owner (استبدل www-data بالـ user المناسب لسيرفرك)
# في Apache/Ubuntu:
sudo chown -R www-data:www-data storage bootstrap/cache

# في Nginx:
sudo chown -R nginx:nginx storage bootstrap/cache

# في cPanel:
sudo chown -R username:username storage bootstrap/cache
```

### التحقق من الصلاحيات

```bash
# شوف صلاحيات storage
ls -la storage/

# شوف صلاحيات public
ls -la public/
```

---

## 🧪 اختبار الموقع

### 1. اختبار من Terminal

```bash
# اختبر أن السيرفر يعمل
php artisan serve --host=0.0.0.0 --port=8000

# ثم افتح في المتصفح:
# http://your-server-ip:8000
```

### 2. اختبار Routes

```bash
# تحقق أن route موجود
php artisan route:list | grep chat

# يجب أن ترى:
# POST  api/chat/article ... chat.article
```

### 3. اختبار API Key

```bash
# اختبر أن Laravel يقرأ المفتاح
php artisan tinker

# داخل tinker، اكتب:
echo env('GEMINI_API_KEY');

# يجب أن يظهر المفتاح
# اضغط Ctrl+C للخروج
```

### 4. اختبار في المتصفح

```
1. افتح موقعك: https://your-domain.com
2. اذهب لأي مقال
3. شوف إذا زر AI Chat ظاهر
4. جربه!
```

---

## 🐛 استكشاف الأخطاء

### المشكلة 1: صفحة بيضاء أو Error 500

**الحل:**

```bash
# شوف الـ logs
tail -f storage/logs/laravel.log

# أو
cat storage/logs/laravel.log | tail -50
```

### المشكلة 2: ملفات CSS/JS لا تعمل

**الحل:**

```bash
# تأكد من الصلاحيات
chmod -R 755 public/css
chmod -R 755 public/js

# امسح cache المتصفح (Ctrl+Shift+R)
```

### المشكلة 3: "Route not found"

**الحل:**

```bash
# امسح route cache
php artisan route:clear

# شوف الـ routes
php artisan route:list
```

### المشكلة 4: "Class not found"

**الحل:**

```bash
# إعادة تحميل autoload
composer dump-autoload

# مسح كل الـ cache
php artisan optimize:clear
```

### المشكلة 5: Database Error

**الحل:**

```bash
# تحقق من اتصال Database في .env
cat .env | grep DB_

# جرب الاتصال
php artisan tinker
DB::connection()->getPdo();

# شغل migrations مرة أخرى
php artisan migrate --force
```

### المشكلة 6: AI Chat لا يعمل

**الحل:**

```bash
# 1. تحقق من API Key
grep GEMINI .env

# 2. تحقق من route
php artisan route:list | grep chat

# 3. شوف الـ logs
tail -f storage/logs/laravel.log

# 4. اختبر API مباشرة
curl -X POST "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{"contents":[{"parts":[{"text":"Hello"}]}]}'
```

### المشكلة 7: "Permission Denied"

**الحل:**

```bash
# أعط صلاحيات كاملة لـ storage
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# ثم أرجعها للصلاحيات الآمنة:
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📊 Checklist النهائي

قبل ما تخلص، تحقق من:

```
✅ git pull نجح بدون أخطاء
✅ migrations اشتغلت
✅ API Key موجود في .env
✅ cache تم مسحه
✅ الصلاحيات صحيحة
✅ الموقع يفتح في المتصفح
✅ زر AI Chat ظاهر
✅ AI Chat يعمل
✅ لا يوجد أخطاء في logs
```

---

## 🔄 تحديثات مستقبلية (الطريقة السريعة)

في المرات القادمة، استخدم هذا Script السريع:

### إنشاء Script للتحديث التلقائي

```bash
# أنشئ ملف deploy.sh
nano deploy.sh
```

ضع فيه:

```bash
#!/bin/bash

echo "🚀 Starting deployment..."

# 1. سحب التحديثات
echo "📥 Pulling from GitHub..."
git pull origin main

# 2. تحديث dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# 3. تشغيل migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# 4. مسح cache
echo "🧹 Clearing cache..."
php artisan optimize:clear

# 5. تحسين الأداء
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. ضبط الصلاحيات
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment complete!"
```

احفظ واخرج، ثم:

```bash
# أعط صلاحيات التنفيذ
chmod +x deploy.sh

# شغله في كل مرة تريد تحديث
./deploy.sh
```

---

## 🎯 أفضل الممارسات

### 1. Backup قبل كل تحديث

```bash
# نسخة احتياطية من Database
php artisan db:backup

# أو يدوياً:
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. اختبار محلي أولاً

```
✅ اختبر التحديثات على جهازك المحلي أولاً
✅ تأكد أن كل شيء يعمل
✅ ثم ارفع على السيرفر
```

### 3. Git Workflow السليم

```bash
# دائماً اعمل pull قبل push
git pull origin main
git add .
git commit -m "Your message"
git push origin main
```

### 4. مراقبة Logs

```bash
# راقب الـ logs بشكل مستمر
tail -f storage/logs/laravel.log

# أو استخدم log viewer
php artisan log:clear
```

---

## 📞 الدعم

### إذا واجهت مشاكل:

1. **شوف الـ logs:**
   ```bash
   tail -50 storage/logs/laravel.log
   ```

2. **شوف error logs السيرفر:**
   ```bash
   # Apache
   tail -50 /var/log/apache2/error.log
   
   # Nginx
   tail -50 /var/log/nginx/error.log
   ```

3. **اتصل بـ Hosting Support** إذا كانت مشكلة في السيرفر

---

## 🎓 نصائح إضافية

### للأداء الأفضل:

```bash
# بعد كل deployment، شغل:
php artisan config:cache
php artisan route:cache
php artisan view:cache

# للـ production فقط!
```

### للأمان:

```bash
# تأكد أن .env غير متاح للعامة
chmod 600 .env

# تأكد أن storage محمي
# أضف في .htaccess داخل storage:
Deny from all
```

### للصيانة:

```bash
# وضع الموقع في وضع الصيانة
php artisan down --message="We'll be back soon!"

# إعادة تشغيل الموقع
php artisan up
```

---

## ✅ تم بنجاح!

الآن موقعك محدّث ومجهز بـ:
- ✅ AI Chat مع Google Gemini
- ✅ Table of Contents
- ✅ جميع التحسينات الجديدة

**استمتع بالموقع الجديد! 🎉**

---

## 📚 المراجع

- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Git Documentation](https://git-scm.com/doc)
- [Google Gemini API](https://ai.google.dev/docs)
- [GitHub Repository](https://github.com/osamayesh/PORTFOLIO)

---

**آخر تحديث:** أكتوبر 2025

