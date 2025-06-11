# MySQL UTF-8 Setup Guide for XAMPP

## Problem
Arabic text appears as question marks (?????) in your MySQL database.

## Solution

### 1. Update MySQL Configuration in XAMPP

Edit the MySQL configuration file in XAMPP:
- Open `C:\xampp\mysql\bin\my.ini` (or `my.cnf`)
- Add or update these lines under the `[mysqld]` section:

```ini
[mysqld]
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci
init-connect='SET NAMES utf8mb4'

[mysql]
default-character-set=utf8mb4

[client]
default-character-set=utf8mb4
```

### 2. Restart MySQL in XAMPP
- Stop MySQL service in XAMPP Control Panel
- Start MySQL service again

### 3. Verify Database Settings
Run these commands in phpMyAdmin or MySQL command line:

```sql
SHOW VARIABLES LIKE 'character_set%';
SHOW VARIABLES LIKE 'collation%';
```

You should see `utf8mb4` for most character set variables.

### 4. Laravel Configuration
Make sure your `.env` file has:

```env
DB_CONNECTION=mysql
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
```

### 5. For Existing Data
If you have existing corrupted data, you'll need to:
1. Re-enter the Arabic text after fixing the charset
2. Or restore from a backup if available

## Prevention
- Always set up UTF-8 support before adding any Arabic content
- Test with a simple Arabic text before adding large amounts of data
- Use `utf8mb4` instead of `utf8` for full Unicode support

## Testing
Create a test record with Arabic text to verify everything works:

```php
$summary = new Summary();
$summary->title_ar = 'اختبار النص العربي';
$summary->description_ar = 'هذا نص تجريبي للتأكد من دعم اللغة العربية';
$summary->save();
``` 