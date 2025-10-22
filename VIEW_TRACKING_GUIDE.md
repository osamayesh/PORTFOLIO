# دليل تتبع المشاهدات - View Tracking Guide

## نظرة عامة
تم تطوير نظام تتبع المشاهدات ليدعم **المشاهدة الدائمة بناءً على IP** حيث يتم احتساب مشاهدة واحدة فقط لكل IP لكل مقال بشكل دائم.

## الفرق بين المشاهدة الدائمة والمؤقتة

### 1. المشاهدة الدائمة (Permanent - افتراضي)
- **كيف تعمل**: IP واحد = مشاهدة واحدة للأبد
- **متى تُحسب المشاهدة**: عند أول زيارة فقط من نفس الـ IP
- **الفائدة**: عدد مشاهدات أكثر دقة وواقعية
- **الاستخدام**: مناسب لمعظم المدونات والمواقع

### 2. المشاهدة المؤقتة (Temporary)
- **كيف تعمل**: يتم احتساب المشاهدة مرة أخرى بعد فترة زمنية محددة (24 ساعة افتراضياً)
- **متى تُحسب المشاهدة**: بعد انتهاء المدة الزمنية المحددة
- **الفائدة**: تتبع المشاهدات المتكررة
- **الاستخدام**: مناسب للمحتوى الذي يتطلب تتبع الزيارات المتكررة

## الإعدادات

### ملف config/app.php

```php
'view_tracking' => [
    'enabled' => true,                    // تفعيل/تعطيل نظام التتبع
    'permanent' => true,                  // true = دائم، false = مؤقت
    'unique_hours' => 24,                 // عدد الساعات (فقط إذا كان permanent = false)
    'cleanup_days' => 365,                // حذف السجلات القديمة بعد X يوم
    'track_bots' => false,                // تتبع الروبوتات (غير مفعل حالياً)
],
```

### متغيرات البيئة (.env)

يمكنك تغيير الإعدادات من خلال ملف `.env`:

```env
VIEW_TRACKING_ENABLED=true
VIEW_TRACKING_PERMANENT=true
VIEW_TRACKING_UNIQUE_HOURS=24
VIEW_TRACKING_CLEANUP_DAYS=365
VIEW_TRACKING_TRACK_BOTS=false
```

## كيفية الاستخدام

### في الـ Controller

```php
// في ArticleController@show
$article = Article::findOrFail($slug);

// تسجيل المشاهدة الفريدة
$isUniqueView = $article->recordUniqueView();

// $isUniqueView = true إذا كانت مشاهدة جديدة
// $isUniqueView = false إذا كان الـ IP شاهد المقال من قبل
```

### في الـ Model

```php
// تسجيل مشاهدة
$article->recordUniqueView();

// الحصول على عدد المشاهدات الفريدة
$uniqueViews = $article->getUniqueViews();

// الحصول على عدد المشاهدات لفترة معينة
$viewsLast30Days = $article->getUniqueViews(30);
```

## قاعدة البيانات

### جدول article_views

```sql
CREATE TABLE article_views (
    id BIGINT PRIMARY KEY,
    article_id BIGINT,
    ip_address VARCHAR(45),      -- يدعم IPv4 و IPv6
    user_agent TEXT,
    session_id VARCHAR(255),
    viewed_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    UNIQUE KEY unique_article_ip_view (article_id, ip_address)
);
```

### الـ Unique Constraint

- **القيد القديم**: `(article_id, ip_address, session_id)` ❌
- **القيد الجديد**: `(article_id, ip_address)` ✅

هذا يضمن أن كل IP يمكنه مشاهدة المقال مرة واحدة فقط.

## التنظيف التلقائي

يمكنك جدولة تنظيف السجلات القديمة:

```php
// في app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // حذف السجلات الأقدم من سنة
    $schedule->call(function () {
        \App\Models\ArticleView::cleanupOldViews(365);
    })->daily();
}
```

## الأمان والخصوصية

### حماية الـ IP
- يتم تشفير الـ IP في قاعدة البيانات (اختياري)
- يمكن إخفاء جزء من الـ IP للخصوصية

### الامتثال لـ GDPR
- السماح للمستخدمين بحذف بياناتهم
- توضيح سياسة الخصوصية

## استكشاف الأخطاء

### المشاهدات لا تُحتسب

1. تأكد من أن `VIEW_TRACKING_ENABLED=true`
2. تحقق من أن الـ migration تم تشغيلها
3. تأكد من وجود الـ unique constraint

```bash
php artisan migrate:status
```

### أخطاء Duplicate Entry

إذا ظهرت أخطاء تكرار، قم بتنظيف البيانات المكررة:

```sql
DELETE t1 FROM article_views t1
INNER JOIN article_views t2 
WHERE t1.id > t2.id 
AND t1.article_id = t2.article_id 
AND t1.ip_address = t2.ip_address;
```

## الإحصائيات المتقدمة

### عرض إحصائيات المشاهدات

```php
// أكثر المقالات مشاهدة
$topArticles = Article::published()
    ->orderBy('views', 'desc')
    ->limit(10)
    ->get();

// المشاهدات لمقال معين
$article = Article::find(1);
$totalViews = $article->views;
$last30DaysViews = $article->getUniqueViews(30);
$last7DaysViews = $article->getUniqueViews(7);
```

## التحديثات المستقبلية

### ميزات مخططة
- [ ] تتبع الدول والمناطق
- [ ] رسوم بيانية للمشاهدات
- [ ] تقارير تفصيلية
- [ ] API للإحصائيات
- [ ] كشف الروبوتات المتقدم

## الأسئلة الشائعة

### س: هل Session مؤقتة؟
**ج**: نعم، الـ Session تنتهي عند إغلاق المتصفح. لهذا السبب نستخدم الـ IP للتتبع الدائم.

### س: ماذا لو تغير الـ IP؟
**ج**: سيتم احتساب المشاهدة مرة أخرى من الـ IP الجديد.

### س: هل يمكن تتبع نفس الشخص من أجهزة مختلفة؟
**ج**: لا، كل جهاز له IP مختلف (عادةً)، لذا سيتم احتساب مشاهدة لكل جهاز.

### س: كيف أعطل المشاهدة الدائمة؟
**ج**: غيّر `VIEW_TRACKING_PERMANENT=false` في ملف `.env`

### س: كيف أحذف كل سجلات المشاهدات؟
**ج**: 
```bash
php artisan tinker
> App\Models\ArticleView::truncate();
> App\Models\Article::query()->update(['views' => 0]);
```

## الدعم
للأسئلة أو المشاكل، يرجى التواصل عبر osama.ay.code@gmail.com

