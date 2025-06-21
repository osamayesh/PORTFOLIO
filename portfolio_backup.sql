-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: portfolio
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_prerequisites`
--

DROP TABLE IF EXISTS `article_prerequisites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_prerequisites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint unsigned NOT NULL,
  `prerequisite_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_prerequisites_article_id_foreign` (`article_id`),
  KEY `article_prerequisites_prerequisite_id_foreign` (`prerequisite_id`),
  CONSTRAINT `article_prerequisites_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_prerequisites_prerequisite_id_foreign` FOREIGN KEY (`prerequisite_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_prerequisites`
--

LOCK TABLES `article_prerequisites` WRITE;
/*!40000 ALTER TABLE `article_prerequisites` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_prerequisites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_views`
--

DROP TABLE IF EXISTS `article_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_article_view` (`article_id`,`ip_address`,`session_id`),
  KEY `article_views_article_id_ip_address_index` (`article_id`,`ip_address`),
  KEY `article_views_article_id_session_id_index` (`article_id`,`session_id`),
  KEY `article_views_viewed_at_index` (`viewed_at`),
  CONSTRAINT `article_views_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_views`
--

LOCK TABLES `article_views` WRITE;
/*!40000 ALTER TABLE `article_views` DISABLE KEYS */;
INSERT INTO `article_views` VALUES (1,3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','jQ0DwXasycIVmIEBd9Id3cVflzPuhMBgJt3l23qs','2025-06-01 21:03:54','2025-06-01 21:03:54','2025-06-01 21:03:54'),(2,4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','xtuGUKMBDWW7LGpYIytNfhonHxEmNAxEUVBmqocO','2025-06-08 13:27:29','2025-06-08 13:27:29','2025-06-08 13:27:29'),(3,5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','QdAcoGmFyw4sFCXc3B0Rs8JjDSXdxc5ltJ3JZBcH','2025-06-10 13:44:23','2025-06-10 13:44:23','2025-06-10 13:44:23'),(4,6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','QdAcoGmFyw4sFCXc3B0Rs8JjDSXdxc5ltJ3JZBcH','2025-06-10 15:53:24','2025-06-10 15:53:24','2025-06-10 15:53:24'),(5,8,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','Fy04Lbs3yo7OcKYuKlcZCax02DRHNE74Sl6KDQJh','2025-06-11 15:04:18','2025-06-11 15:04:18','2025-06-11 15:04:18'),(6,4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','IyJLnyzW6XTAirrnAXJ6ygcwjVCPZrlmHEuVeGQg','2025-06-13 14:53:26','2025-06-13 14:53:26','2025-06-13 14:53:26');
/*!40000 ALTER TABLE `article_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` longtext COLLATE utf8mb4_unicode_ci,
  `content_ar` longtext COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `read_time` int DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `series_id` bigint unsigned DEFAULT NULL,
  `series_order` int DEFAULT NULL,
  `prerequisites` text COLLATE utf8mb4_unicode_ci,
  `prerequisites_ar` text COLLATE utf8mb4_unicode_ci,
  `programming_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `framework` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_category_id_foreign` (`category_id`),
  KEY `articles_series_id_foreign` (`series_id`),
  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `articles_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `articles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,12,'Create a Custom Action Selector in ASP.NET MVC','create-a-custom-action-selector-in-aspnet-mvc','Create a Custom Action Selector in ASP.NET MVC','إنشاء محدد إجراء مخصص في ASP.NET MVC','Learn how to create and use custom action selectors in ASP.NET MVC to control action method selection based on custom logic','Learn how to create and use custom action selectors in ASP.NET MVC to control action method selection based on custom logic','تعرف على كيفية إنشاء محددات الإجراءات المخصصة واستخدامها في ASP.NET MVC للتحكم في طريقة تحديد الإجراء استنادًا إلى المنطق المخصص','Action selectors are attributes that can be applied to action methods. The MVC framework uses Action Selector attribute to invoke correct action.\r\n\r\nYou can create custom action selectors by implementing the ActionMethodSelectorAttribute abstract class.\r\n\r\nFor example, create custom action selector attribute AjaxRequest to indicate that the action method will only be invoked using the Ajax request as shown below.','Action selectors are attributes that can be applied to action methods. The MVC framework uses Action Selector attribute to invoke correct action.\r\n\r\nYou can create custom action selectors by implementing the ActionMethodSelectorAttribute abstract class.\r\n\r\nFor example, create custom action selector attribute AjaxRequest to indicate that the action method will only be invoked using the Ajax request as shown below.','محددات الإجراءات هي سمات يمكن تطبيقها على أساليب الإجراء. يستخدم إطار عمل MVC سمة محدد الإجراءات لاستدعاء الإجراء الصحيح. يمكنك إنشاء محددات إجراءات مخصصة بتطبيق الفئة المجردة ActionMethodSelectorAttribute. على سبيل المثال، أنشئ سمة محدد إجراءات مخصصة AjaxRequest للإشارة إلى أن أسلوب الإجراء سيتم استدعاؤه فقط باستخدام طلب Ajax كما هو موضح أدناه.',NULL,'[\"tag1\"]',NULL,0,1,'2025-05-31 10:53:00','2025-05-31 10:53:21','2025-06-01 20:59:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,12,'What is RouteData in MVC?','what-is-routedata-in-mvc','What is RouteData in MVC?','RouteData في MVC','Learn what RouteData is in ASP.NET MVC, how it works during the routing process, and how it helps the framework determine which controller and action to invoke.','Learn what RouteData is in ASP.NET MVC, how it works during the routing process, and how it helps the framework determine which controller and action to invoke.','تعرّف على RouteData في ASP.NET MVC، وكيف يعمل أثناء عملية التوجيه (Routing)، ودوره في تحديد الـ Controller والإجراء (Action) المناسبين لتنفيذ الطلب.','RouteData is a property of the base Controller class, so RouteData can be accessed in any controller. RouteData contains route information of a current request. You can get the controller, action or parameter information using RouteData as shown below.','RouteData is a property of the base Controller class, so RouteData can be accessed in any controller. RouteData contains route information of a current request. You can get the controller, action or parameter information using RouteData as shown below.','<p><strong>RouteData</strong> هي خاصية من خصائص فئة وحدة التحكم الأساسية، لذا يُمكن الوصول إليها من أي وحدة تحكم. تحتوي <strong>RouteData</strong> على معلومات مسار الطلب الحالي. يمكنك الحصول على معلومات وحدة التحكم أو الإجراء أو المعلمة باستخدام <strong>RouteData</strong> كما هو موضح أدناه.</p>',NULL,'[\"tag12\"]',NULL,0,1,'2025-05-31 15:20:00','2025-05-31 15:20:57','2025-06-01 20:59:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,8,'difference between Non-Clustered Index and Clustered Index','difference-between-non-clustered-index-and-clustered-index','difference between Non-Clustered Index and Clustered Index','الفرق بين Clustered Index و Non-Clustered Index','When managing a database, especially at scale, performance becomes critical — and indexes play a vital role in speeding up queries. Among the different types of indexes, Clustered and Non-Clustered are the most common and essential to understand.','When managing a database, especially at scale, performance becomes critical — and indexes play a vital role in speeding up queries. Among the different types of indexes, Clustered and Non-Clustered are the most common and essential to understand.','لما تبلّش تشتغل على قواعد البيانات، وخصوصًا قواعد البيانات الكبيرة زي SQL Server أو MySQL، أكيد رح تسمع مصطلحات مثل Clustered Index و Non-Clustered Index.','<p>What is an Index?</p><p>\r\nAn index is like a roadmap for your data. It helps the database engine quickly find records without scanning the entire table.\r\nJust like the index of a book — instead of flipping every page, you check the index and go directly to the right page.\r\n🔷 Clustered Index: Data is Physically Ordered\r\nA Clustered Index defines the physical order of rows in a table based on the indexed column.\r\nThe data itself is sorted and stored on disk in the same order as the index.\r\n\r\n✅ Key Points:\r\nOnly one clustered index is allowed per table.\r\n\r\nThe data rows themselves are part of the index.\r\n\r\nVery efficient for range queries and sorting operations.\r\n\r\n📌 Real-life Example:\r\nIf students are stored in order of their StudentID, and you\'re looking for ID 300, the database can jump straight to it without scanning everything.\r\n\r\n🟡 Non-Clustered Index: Separate Structure for Searching\r\nA Non-Clustered Index is stored separately from the actual table data.\r\nIt contains indexed values and a pointer to the location of the actual data row.\r\n\r\n✅ Key Points:\r\nYou can have multiple non-clustered indexes on a table.\r\n\r\nIt does not change the physical order of data.\r\n\r\nBest for columns that are frequently filtered or searched.\r\n\r\n📌 Lookup Process:\r\nThe engine searches the index for the value.\r\n\r\nIt uses the pointer to fetch the full row from the main table (this is called a Key Lookup).\r\n\r\n📌 Real-life Example:\r\nIf you\'re searching for Name = \'Sarah\', the index quickly locates \"Sarah\" and points to her full record in the base table.\r\n\r\n📊 Summary of Differences (in plain words)\r\nA Clustered Index stores the data physically sorted by the indexed column.\r\n\r\nA Non-Clustered Index uses a separate structure and just points to the data.\r\n\r\nOnly one clustered index is allowed per table, but you can have many non-clustered indexes.\r\n\r\nClustered indexes are best for range queries or sorting.\r\n\r\nNon-clustered indexes are best for frequent lookups on columns like names, emails, or statuses.\r\n\r\n🎯 When to Use Each?\r\nUse a Clustered Index on:\r\n\r\nPrimary keys\r\n\r\nDate fields\r\n\r\nColumns commonly sorted or queried in ranges\r\n\r\nUse a Non-Clustered Index on:\r\n\r\nColumns that are filtered often (e.g., name, email, status)\r\n\r\nFields used in reporting or search operations\r\n\r\n<span style=\"color: rgb(0, 102, 204);\"> Example for Clarity</span></p>','<p>What is an Index?</p><p>\r\nAn index is like a roadmap for your data. It helps the database engine quickly find records without scanning the entire table.\r\nJust like the index of a book — instead of flipping every page, you check the index and go directly to the right page.\r\n🔷 Clustered Index: Data is Physically Ordered\r\nA Clustered Index defines the physical order of rows in a table based on the indexed column.\r\nThe data itself is sorted and stored on disk in the same order as the index.\r\n\r\n✅ Key Points:\r\nOnly one clustered index is allowed per table.\r\n\r\nThe data rows themselves are part of the index.\r\n\r\nVery efficient for range queries and sorting operations.\r\n\r\n📌 Real-life Example:\r\nIf students are stored in order of their StudentID, and you\'re looking for ID 300, the database can jump straight to it without scanning everything.\r\n\r\n🟡 Non-Clustered Index: Separate Structure for Searching\r\nA Non-Clustered Index is stored separately from the actual table data.\r\nIt contains indexed values and a pointer to the location of the actual data row.\r\n\r\n✅ Key Points:\r\nYou can have multiple non-clustered indexes on a table.\r\n\r\nIt does not change the physical order of data.\r\n\r\nBest for columns that are frequently filtered or searched.\r\n\r\n📌 Lookup Process:\r\nThe engine searches the index for the value.\r\n\r\nIt uses the pointer to fetch the full row from the main table (this is called a Key Lookup).\r\n\r\n📌 Real-life Example:\r\nIf you\'re searching for Name = \'Sarah\', the index quickly locates \"Sarah\" and points to her full record in the base table.\r\n\r\n📊 Summary of Differences (in plain words)\r\nA Clustered Index stores the data physically sorted by the indexed column.\r\n\r\nA Non-Clustered Index uses a separate structure and just points to the data.\r\n\r\nOnly one clustered index is allowed per table, but you can have many non-clustered indexes.\r\n\r\nClustered indexes are best for range queries or sorting.\r\n\r\nNon-clustered indexes are best for frequent lookups on columns like names, emails, or statuses.\r\n\r\n🎯 When to Use Each?\r\nUse a Clustered Index on:\r\n\r\nPrimary keys\r\n\r\nDate fields\r\n\r\nColumns commonly sorted or queried in ranges\r\n\r\nUse a Non-Clustered Index on:\r\n\r\nColumns that are filtered often (e.g., name, email, status)\r\n\r\nFields used in reporting or search operations\r\n\r\n<span style=\"color: rgb(0, 102, 204);\"> Example for Clarity</span></p>','<p>✅ أول إشي: شو يعني Index بشكل عام؟\r\nالإندكس (Index) هو زي فهرس أو دليل للبيانات. الهدف منه إنك توصل للبيانات بسرعة، بدل ما النظام يدور على القيمة صف صف من فوق لتحت.\r\nيعني لو عندك مليون صف، وما فيش إندكس، النظام راح يضطر يعمل Table Scan ويمر على كل الصفوف — وهذا بطيء جدًا.\r\nلكن لو عامل إندكس، النظام راح يروح مباشرة زي كأنك فتحت فهرس كتاب وشفت رقم الصفحة اللي فيها الموضوع.\r\n🔶 Clustered Index: لما البيانات نفسها تكون مرتبة\r\nالـ Clustered Index هو الإندكس الأساسي، واللي بيأثر على ترتيب البيانات الفعلي على القرص.\r\nيعني لو عملت Clustered على العمود ID، البيانات راح تكون مرتبة فعليًا حسب الـ ID، مش بس الفهرسة، حتى طريقة التخزين على القرص.\r\n✅ أهم ميزاته:\r\nسريع جدًا في البحث، خاصة لما تستعلم عن نطاق معين (مثلاً: بين ID 100 و ID 200).\r\nمسموح تعمل واحد فقط في كل جدول، لأنه ما بصير ترتب الجدول بأكثر من طريقة.\r\n📌 مثال واقعي:\r\nعندك جدول طلاب مرتب حسب رقم الطالب، لو بدك تدوّر على طالب رقمه 112، النظام بروح مباشرة عليه، لأنه مرتب أصلاً.\r\n\r\n🔷 Non-Clustered Index: فهرسة بدون تغيير ترتيب البيانات\r\nالـ Non-Clustered Index هو زي مرجع منفصل.\r\nبيعمل جدول داخلي صغير يحتوي على القيم المفهرسة (مثلاً الأسماء)، ومعاها مؤشرات (Pointers) بتدلك على مكان الصف الأصلي.\r\n✅ ميزاته:\r\nتقدر تعمل أكثر من واحد على نفس الجدول.\r\nمفيد جدًا لتسريع الاستعلامات على أعمدة مش مرتبة، مثل الاسم أو الإيميل.\r\n📌 Lookup Process:\r\nأولًا: النظام يدور على القيمة داخل الإندكس.\r\nبعدين: يروح يجيب الصف الكامل من مكانه بالجدول (هاي اسمها Key Lookup).\r\n\r\n📌 مثال واقعي:\r\nلو بدك تدوّر على طالب اسمه \"خالد\"، النظام بدوّر عليه بالإندكس تبع الأسماء، وبس يلاقيه، بروح يجيب باقي بياناته من الجدول.\r\n\r\n📊 الفرق الفعلي بينهم:\r\nClustered Index: بيأثر على ترتيب وتخزين البيانات فعليًا.\r\n\r\nNon-Clustered Index: ما بيغير الترتيب، بس بيعمل هيكل خارجي للبحث.\r\n\r\nClustered أسرع لما تسأل عن عدة سجلات أو نطاق.\r\n\r\nNon-Clustered بيساعد لما بدك تسأل عن أعمدة مختلفة مش مرتبة.\r\n\r\n🤔 طيب، شو أستخدم ومتى؟\r\n✅ استخدم Clustered Index لما:\r\n\r\nالعمود أساسي في البحث، مثل ID أو تاريخ الإنشاء.\r\n\r\n✅ استخدم Non-Clustered Index لما:\r\n\r\nالأعمدة بتتكرر فيها عمليات الفلترة والبحث، مثل: الاسم، الإيميل، رقم الهاتف.\r\n\r\nأو لما عندك تقارير بتعتمد على أعمدة ثابتة.</p><h1><span style=\"color: rgb(0, 102, 204);\">مثال للتوضيح</span></h1><h1><br></h1>',NULL,'[\"tag1\"]',15,1,1,'2025-06-01 17:57:00','2025-06-01 17:57:36','2025-06-01 21:03:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,23,'Laravel vs .NET Core: An In-Depth Comparison of Performance, Security, Data Handling, and Developer Experience','laravel-vs-net-core-an-in-depth-comparison-of-performance-security-data-handling-and-developer-experience','Laravel vs .NET Core: An In-Depth Comparison of Performance, Security, Data Handling, and Developer Experience','مقارنة متعمقة بين Laravel و .NET Core: الأداء، الأمان، قواعد البيانات، وتجربة المطور','A detailed comparison between Laravel and .NET Core covering performance, security, data handling, and developer experience. A practical guide to help you choose the right framework for your next project.','A detailed comparison between Laravel and .NET Core covering performance, security, data handling, and developer experience. A practical guide to help you choose the right framework for your next project.','مقارنة تفصيلية بين Laravel و .NET Core تشمل الأداء، الأمان، إدارة البيانات، وتجربة المطور. دليل عملي يساعدك في اختيار التقنية الأنسب لمشروعك القادم.','<h1><strong>Introduction</strong>:</h1><p>Many people often ask: <em>What’s the core difference between Laravel and .NET in web development?</em> Which one offers <strong>better performance</strong>, <strong>richer libraries</strong>, <strong>cleaner code practices</strong>, and better <strong>support for design principles and patterns</strong>?</p><p>In reality, both Laravel (PHP) and .NET (C#) are powerful frameworks for building data-driven applications. Laravel comes with <strong>Eloquent</strong>, a simple and elegant ORM. .NET, on the other hand, offers <strong>Entity Framework Core (EF Core)</strong>, a robust and flexible ORM with deep LINQ integration.</p><p>This article will help you clearly see the <strong>core differences</strong> between the two by comparing them in terms of:</p><ul><li>Data Handling</li><li>Relationships</li><li>Performance</li><li>Security</li><li>Developer Experience</li><li>Scalability</li><li>Clean Code &amp; Architecture Support</li><li>AI/ML Integration</li></ul><p><br></p><p><br></p>','<h1><strong>Introduction</strong>:</h1><p>Many people often ask: <em>What’s the core difference between Laravel and .NET in web development?</em> Which one offers <strong>better performance</strong>, <strong>richer libraries</strong>, <strong>cleaner code practices</strong>, and better <strong>support for design principles and patterns</strong>?</p><p>In reality, both Laravel (PHP) and .NET (C#) are powerful frameworks for building data-driven applications. Laravel comes with <strong>Eloquent</strong>, a simple and elegant ORM. .NET, on the other hand, offers <strong>Entity Framework Core (EF Core)</strong>, a robust and flexible ORM with deep LINQ integration.</p><p>This article will help you clearly see the <strong>core differences</strong> between the two by comparing them in terms of:</p><ul><li>Data Handling</li><li>Relationships</li><li>Performance</li><li>Security</li><li>Developer Experience</li><li>Scalability</li><li>Clean Code &amp; Architecture Support</li><li>AI/ML Integration</li></ul><p><br></p><p><br></p>','<h1><strong>المقدمة</strong>: </h1><p>يسأل الكثيرون: <em>ما الفرق الجوهري بين Laravel و .NET في تطوير الويب؟</em> وأيهما يقدم أداء أفضل، مكتبات أغنى، ودعمًا أقوى للبرمجة النظيفة والمبادئ المعمارية (Design Patterns &amp; Principles)؟</p><p>في الحقيقة، كلا الإطارين Laravel (بلغة PHP) و.NET (بلغة C#) يُعدّان من أقوى الخيارات لتطوير التطبيقات المعتمدة على البيانات. حيث يوفر Laravel أداة ORM تسمى <strong>Eloquent</strong> تُعرف ببساطتها وسهولة استخدامها، بينما تقدم .NET أداة <strong>Entity Framework Core (EF Core)</strong>، وهي ORM قوية تدعم LINQ وتمنح تحكمًا متقدمًا في البيانات.</p><p>في هذا المقال، ستتعرف على الفرق الجوهري بين الاثنين من خلال المقارنة في الجوانب التالية:</p><p><br></p><ul><li>     التعامل مع البيانات </li><li>    العلاقات</li><li>   الاداء </li><li>   الامان </li><li>   تجربه المطور </li><li>   قابليه التوسع</li><li>   دعم البرمجة النظيفة والمعمارية</li><li>   تكامل الذكاء الاصطناعي والتعلم الالة</li></ul>',NULL,'[\"tag3\"]',NULL,2,1,'2025-06-08 13:24:00','2025-06-08 13:24:05','2025-06-13 14:53:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,14,'input type button vs button','input-type-button-vs-button','input type button vs button','الاختلاف  بين input type button و button','learn the main differences between them','learn the main differences between them','تعلم الاختلاف الصحيح بينهم','<p><span style=\"color: rgb(255, 255, 255);\">The main difference between&nbsp;</span><code style=\"color: rgb(255, 255, 255); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code><span style=\"color: rgb(255, 255, 255);\">&nbsp;and&nbsp;</span><code style=\"color: rgb(255, 255, 255); background-color: rgb(225, 225, 225);\"><em>&lt;button&gt;</em></code><span style=\"color: rgb(255, 255, 255);\">&nbsp;is that the latter allows for more customization and is more flexible.</span></p><p class=\"ql-align-justify\"><code style=\"color: rgb(167, 139, 250); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code>&nbsp;&nbsp;is <strong>self-contained</strong> and has limited functionality. You can set the button text using the <code>value</code> attribute, but it does not allow for complex styling or additional content inside the element.</p><p><code>&lt;button&gt;</code> is <strong>more versatile</strong> because it can <strong>contain other elements</strong>, such as text, icons, or spans. This allows for more complex styling using CSS pseudo-elements.</p><p><code>&lt;button&gt;</code> can have different <code>type</code> values (<code>button</code>, <code>submit</code>, <code>reset</code>), making it useful in forms.</p><p><br></p><p>Example Comparison:</p>','<p><span style=\"color: rgb(255, 255, 255);\">The main difference between&nbsp;</span><code style=\"color: rgb(255, 255, 255); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code><span style=\"color: rgb(255, 255, 255);\">&nbsp;and&nbsp;</span><code style=\"color: rgb(255, 255, 255); background-color: rgb(225, 225, 225);\"><em>&lt;button&gt;</em></code><span style=\"color: rgb(255, 255, 255);\">&nbsp;is that the latter allows for more customization and is more flexible.</span></p><p class=\"ql-align-justify\"><code style=\"color: rgb(167, 139, 250); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code>&nbsp;&nbsp;is <strong>self-contained</strong> and has limited functionality. You can set the button text using the <code>value</code> attribute, but it does not allow for complex styling or additional content inside the element.</p><p><code>&lt;button&gt;</code> is <strong>more versatile</strong> because it can <strong>contain other elements</strong>, such as text, icons, or spans. This allows for more complex styling using CSS pseudo-elements.</p><p><code>&lt;button&gt;</code> can have different <code>type</code> values (<code>button</code>, <code>submit</code>, <code>reset</code>), making it useful in forms.</p><p><br></p><p>Example Comparison:</p>','<p>الاختلاف الأساسي بين &nbsp;<code style=\"color: rgb(167, 139, 250); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code>&nbsp;و ال  <code style=\"color: rgb(167, 139, 250); background-color: rgb(225, 225, 225);\"><em>&lt;button&gt;</em></code> انو الاخير يسمح بتخصيص أكبر ويكون أكثر مرونة. </p><p><code style=\"color: rgb(167, 139, 250); background-color: rgb(225, 225, 225);\"><em>&lt;input type=\"button\"&gt;</em></code>&nbsp;<strong>مستقلًا بذاته  </strong>يعني أنه لا يحتوى على اي محتويات داخليه  &nbsp;النص الذي يظهر على الزر يتم تحديده بواسطة الخاصية&nbsp;<code>value</code>.&nbsp; وبالتالي  بس بتقدر تعديل النص والخصائص البسيطة مثل الألوان والحواف <strong>HTML </strong></p><p>ولا بتقدر  تحط اي عنصر زي  صوره او span  جواتهز</p><p><br></p><p>ال <code style=\"background-color: rgb(240, 240, 240);\">&lt;button&gt;</code> هذا العنصر أكثر <strong>مرونة</strong> لأنه ليس محدودًا تقدر أن تضيف بداخله عناصر متعددة مثل <code>&lt;span&gt;</code>, <code>&lt;img&gt;</code></p><p>أو حتى عناصر تنسيقية مختلفة هاي الخاصية تمنحك القدرة على تخصيص محتوى الزر بشكل دقيق لتلبية احتياجات تصميمية وتفاعلية أكبر</p>',NULL,NULL,20,1,1,'2025-06-10 13:44:00','2025-06-10 13:44:00','2025-06-10 13:48:50',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,8,'what\'s SQL Key?','whats-sql-key','what\'s SQL Key?','ايش هو SQL Keys','know what\'s SQL key and his types','know what\'s SQL key and his types','اعرف مفتاح الداتا بيس وانواعو','<p>In SQL, a <strong>key </strong>is a column or a combination of columns that uniquely identifies a record in a table. Keys are used to enforce integrity constraints and to establish relationships between tables. There are several types of keys in SQL</p><p><br></p><p>Example:</p>','<p>In SQL, a <strong>key </strong>is a column or a combination of columns that uniquely identifies a record in a table. Keys are used to enforce integrity constraints and to establish relationships between tables. There are several types of keys in SQL</p><p><br></p><p>Example:</p>','<p>في SQL، <strong>المفتاح </strong>هو عمود أو مجموعة أعمدة تُعرّف سجلًا فريدًا في جدول. تُستخدم المفاتيح لفرض قيود التكامل وإقامة علاقات بين الجداول.</p><p> هناك عدة أنواع من المفاتيح في SQL، </p><p>على سبيل المثال:</p>',NULL,NULL,NULL,1,1,'2025-06-10 15:52:00','2025-06-10 15:19:03','2025-06-10 15:54:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,23,'what\'s programming','whats-programming','what\'s programming','البلابتا','hgjhkg','hgjhkg','ابللابتا','<p><br></p>','<p><br></p>','<p>لبتابت</p>',NULL,NULL,NULL,0,0,NULL,'2025-06-11 14:37:06','2025-06-11 14:39:10','2025-06-11 14:39:10',NULL,NULL,NULL,NULL,NULL,NULL),(8,24,'whats https in Api ?','whats-https-in-api','whats https in Api ?','ايش هو ال HTTPS API','HTTPS in an API refers to using Hypertext Transfer Protocol Secure (HTTPS)','HTTPS in an API refers to using Hypertext Transfer Protocol Secure (HTTPS)','الـ HTTPS بالـ API هو بروتوكول بيأمن الاتصال بين السيرفر والعميل، بحيث البيانات بتكون مشفرة وما حدا بقدر يتجسس عليها أو يعدلها. بستخدم SSL/TLS عشان يضمن الحماية، التوثيق، وسلامة المعلومات خلال النقل.','<p><strong>HTTPS in an API</strong> refers to using <strong>Hypertext Transfer Protocol Secure (HTTPS)</strong> instead of HTTP to ensure secure communication between clients and servers. It encrypts data using <strong>SSL/TLS</strong>, protecting sensitive information from interception, tampering, or unauthorized access.</p><h3><strong>Why Use HTTPS in APIs?</strong></h3><ul><li><strong>Encryption:</strong> Prevents data from being read by attackers.</li><li><strong>Authentication:</strong> Ensures the client is communicating with the correct server.</li><li><strong>Data Integrity:</strong> Protects against unauthorized modifications during transmission.</li></ul><h3><strong>How to Implement HTTPS in an API?</strong></h3><ol><li><strong>Obtain an SSL/TLS Certificate</strong> from a trusted Certificate Authority (CA).</li><li><strong>Configure the API Server</strong> to use HTTPS (e.g., enabling SSL in IIS or setting up HTTPS in ASP.NET Core).</li><li><strong>Redirect HTTP Requests to HTTPS</strong> to enforce secure connections.</li><li><strong>Validate Certificates</strong> on the client side to prevent man-in-the-middle attacks.</li></ol><p>HTTP defines several request methods, often referred to as <strong>HTTP verbs</strong>, that specify the action to be performed on a resource. Here are the main types:</p><ol><li><strong>GET</strong> – Retrieves data from a server without modifying it.</li><li><strong>POST</strong> – Sends data to the server, often creating a new resource.</li><li><strong>PUT</strong> – Updates or replaces an existing resource.</li><li><strong>PATCH</strong> – Partially updates a resource.</li><li><strong>DELETE</strong> – Removes a specified resource.</li><li><strong>HEAD</strong> – Similar to GET but only returns headers, not the body.</li><li><strong>OPTIONS</strong> – Describes communication options for a resource.</li><li><strong>CONNECT</strong> – Establishes a tunnel to a server (used for proxies).</li><li><strong>TRACE</strong> – Performs a loop-back test to track request paths.</li></ol><p>Each method has specific use cases and behaviors, such as whether they are <strong>safe</strong>, <strong>idempotent</strong>, or <strong>cacheable</strong></p><p><br></p><p><br></p>','<p><strong>HTTPS in an API</strong> refers to using <strong>Hypertext Transfer Protocol Secure (HTTPS)</strong> instead of HTTP to ensure secure communication between clients and servers. It encrypts data using <strong>SSL/TLS</strong>, protecting sensitive information from interception, tampering, or unauthorized access.</p><h3><strong>Why Use HTTPS in APIs?</strong></h3><ul><li><strong>Encryption:</strong> Prevents data from being read by attackers.</li><li><strong>Authentication:</strong> Ensures the client is communicating with the correct server.</li><li><strong>Data Integrity:</strong> Protects against unauthorized modifications during transmission.</li></ul><h3><strong>How to Implement HTTPS in an API?</strong></h3><ol><li><strong>Obtain an SSL/TLS Certificate</strong> from a trusted Certificate Authority (CA).</li><li><strong>Configure the API Server</strong> to use HTTPS (e.g., enabling SSL in IIS or setting up HTTPS in ASP.NET Core).</li><li><strong>Redirect HTTP Requests to HTTPS</strong> to enforce secure connections.</li><li><strong>Validate Certificates</strong> on the client side to prevent man-in-the-middle attacks.</li></ol><p>HTTP defines several request methods, often referred to as <strong>HTTP verbs</strong>, that specify the action to be performed on a resource. Here are the main types:</p><ol><li><strong>GET</strong> – Retrieves data from a server without modifying it.</li><li><strong>POST</strong> – Sends data to the server, often creating a new resource.</li><li><strong>PUT</strong> – Updates or replaces an existing resource.</li><li><strong>PATCH</strong> – Partially updates a resource.</li><li><strong>DELETE</strong> – Removes a specified resource.</li><li><strong>HEAD</strong> – Similar to GET but only returns headers, not the body.</li><li><strong>OPTIONS</strong> – Describes communication options for a resource.</li><li><strong>CONNECT</strong> – Establishes a tunnel to a server (used for proxies).</li><li><strong>TRACE</strong> – Performs a loop-back test to track request paths.</li></ol><p>Each method has specific use cases and behaviors, such as whether they are <strong>safe</strong>, <strong>idempotent</strong>, or <strong>cacheable</strong></p><p><br></p><p><br></p>','<p><strong>الـ HTTPS في الـ API</strong> هو بروتوكول أمان بنستخدمه بدل الـ HTTP عشان نضمن اتصال آمن بين السيرفر والعميل. بعمل تشفير للبيانات باستخدام <strong>SSL/TLS</strong>، وبيحمي المعلومات الحساسة من التجسس أو التلاعب أو الوصول غير المصرح فيه.</p><h3><strong>ليش لازم نستخدم HTTPS بالـ API؟</strong></h3><p>🔒 <strong>التشفير:</strong> بحمي البيانات من إنه يتم قراءتها من قبل المخترقين. </p><p>✅ <strong>التوثيق:</strong> بيضمن إنك بتتواصل مع السيرفر الصح مش واحد مزيف. 🛡️ <strong>سلامة البيانات:</strong> بيمنع أي تعديل غير مصرح فيه على المعلومات أثناء نقلها.</p><h3><strong>كيف تفعل HTTPS بالـ API؟</strong></h3><p>1️⃣ <strong>بتجيب شهادة SSL/TLS</strong> من جهة موثوقة. 2️⃣ <strong>بتضبط إعدادات السيرفر</strong> عشان يستخدم HTTPS (مثل تفعيله في IIS أو ASP.NET Core). 3️⃣ <strong>بتعمل تحويل تلقائي لكل طلبات HTTP لـ HTTPS</strong> عشان تجبر الاتصال يكون آمن. 4️⃣ <strong>بتتأكد إن العملاء بيفحصوا الشهادة</strong> عشان يتجنبوا أي هجمات \"رجل في المنتصف\" (Man-in-the-middle attack).</p><h3><strong>أنواع الـ HTTP Requests</strong></h3><p>كل طلب HTTP بيحدد شو العملية اللي رح تتنفذ على المورد. هاي أهم الأنواع:</p><p>📥 <strong>GET:</strong> بيجيب بيانات من السيرفر بدون تعديلها. 📤 <strong>POST:</strong> بيرسل بيانات للسيرفر لإنشاء مورد جديد. 🔄 <strong>PUT:</strong> بيعدل أو يستبدل مورد موجود. ✍️ <strong>PATCH:</strong> بيعدل جزء معين من مورد بدون تغييره كامل. 🗑️ <strong>DELETE:</strong> بيحذف المورد المحدد. 🔎 <strong>HEAD:</strong> زي الـ GET بس برجع الهيدرز فقط بدون المحتوى. ⚙️ <strong>OPTIONS:</strong> بيبين خيارات الاتصال المتاحة مع المورد. 🔗 <strong>CONNECT:</strong> بيفتح نفق لسيرفر (بيستخدم بالـ proxies). 🛠️ <strong>TRACE:</strong> بيعمل اختبار لمسار الطلب عشان يعرف طريقة وصوله.</p><p>كل نوع من هاي الطلبات إله استخدامات محددة، وبعضها بيكون <strong>آمن</strong> أو <strong>قابل للتخزين المؤقت</strong> حسب الحاجة.</p>',NULL,NULL,20,1,1,'2025-06-11 15:02:00','2025-06-11 15:02:17','2025-06-11 15:20:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Programming Basics','أساسيات البرمجة','programming-basics','Fundamental programming concepts and basics',10,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(2,NULL,'OOP Principles','مبادئ البرمجة الكائنية','oop-principles','Object-oriented programming principles and concepts',20,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(3,NULL,'Data Structures','هياكل البيانات','data-structures','Data structures and algorithms',30,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(4,NULL,'Design Patterns','أنماط التصميم','design-patterns','Software design patterns and best practices',40,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(5,NULL,'API Development','تطوير واجهات التطبيقات','api-development','API development and integration',50,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(6,NULL,'JavaScript Fundamentals','أساسيات جافا سكريبت','javascript-fundamentals','JavaScript programming fundamentals',60,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(7,NULL,'Git Version Control','التحكم بالإصدارات Git','git-version-control','Git version control and collaboration',70,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(8,NULL,'Databases','قواعد البيانات','databases','Database design and management',80,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(9,NULL,'Advanced Topics','مواضيع متقدمة','advanced-topics','Advanced programming topics and concepts',90,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(10,NULL,'Personal Blog','مدونة شخصية','personal-blog','Personal thoughts and experiences',100,1,'2025-05-30 20:51:32','2025-05-30 20:51:32'),(12,NULL,'ASP.NET MVC','النمط المعماري MVC (النموذج-العرض-المتحكم','aspnet-mvc',NULL,120,1,'2025-05-31 09:37:07','2025-05-31 09:37:07'),(13,NULL,'cloud computing','حوسبه السحابية','c',NULL,8,1,'2025-06-02 17:28:31','2025-06-02 17:28:31'),(14,1,'HTML Basics','أساسيات HTML','html-basics','Learn the fundamentals of HTML markup language',10,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(15,1,'CSS Styling','تنسيق CSS','css-styling','Styling web pages with CSS',20,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(16,1,'JavaScript Basics','أساسيات JavaScript','javascript-basics','Introduction to JavaScript programming',30,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(17,9,'Microservices','الخدمات المصغرة','microservices','Building scalable microservice architectures',10,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(18,9,'Docker & Containers','Docker والحاويات','docker-containers','Containerization with Docker',20,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(19,8,'MySQL','MySQL','mysql','MySQL database management and optimization',10,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(20,8,'NoSQL','NoSQL','nosql','NoSQL databases like MongoDB, Redis',20,1,'2025-06-02 21:59:43','2025-06-02 21:59:43'),(22,13,'amazon aws','امازون aws','a',NULL,20,1,'2025-06-03 19:37:18','2025-06-03 19:37:18'),(23,NULL,'Web Devlopment framework','تكنولوجيا تطوير الويب','w',NULL,1,1,'2025-06-07 15:30:25','2025-06-07 15:30:25'),(24,23,'API','الAPI','api',NULL,130,1,'2025-06-11 14:54:57','2025-06-11 14:54:57');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code_snippets`
--

DROP TABLE IF EXISTS `code_snippets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `code_snippets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `code` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `show_line_numbers` tinyint(1) NOT NULL DEFAULT '1',
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_after` longtext COLLATE utf8mb4_unicode_ci,
  `content_after_en` longtext COLLATE utf8mb4_unicode_ci,
  `content_after_ar` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `code_snippets_article_id_order_index` (`article_id`,`order`),
  CONSTRAINT `code_snippets_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_snippets`
--

LOCK TABLES `code_snippets` WRITE;
/*!40000 ALTER TABLE `code_snippets` DISABLE KEYS */;
INSERT INTO `code_snippets` VALUES (1,1,NULL,'Create a Custom Action Selector','إنشاء آلية مخصصة لاختيار الإجراءات (Methods) في ASP.NET MVC','text','public class AjaxRequest: ActionMethodSelectorAttribute\r\n{\r\n    public override bool IsValidForRequest(ControllerContext controllerContext, System.Reflection.MethodInfo methodInfo)\r\n    {\r\n        return controllerContext.HttpContext.Request.IsAjaxRequest();\r\n    }\r\n}',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,'2025-05-31 10:53:21','2025-05-31 11:01:10'),(2,1,NULL,'Apply Custom Action Selector','تطبيق محدد الإجراء المخصص','text','[AjaxRequest()]\r\n[HttpPost]\r\npublic ActionResult Edit(int id)\r\n{\r\n    //write update code here..\r\n\r\n    return View();\r\n}',NULL,'In the above code, we have created the new AjaxRequest class deriving from ActionMethodSelectorAttribute and overridden the IsValidForRequest() method.\r\n\r\nSo now, we can apply AjaxRequest attributes to any action method which handles the Ajax request, as shown below:','والآن، يمكننا تطبيق سمات AjaxRequest على أي طريقة عمل تتعامل مع طلب Ajax، كما هو موضح أدناه:',1,1,NULL,NULL,NULL,NULL,'2025-05-31 11:01:10','2025-05-31 11:05:17'),(3,2,NULL,'RouteData in MVC','RouteData في MVC','text','public class StudentController : Controller\r\n{\r\n    public ActionResult Index(int? id, string name, int? standardId)\r\n    {\r\n        var controller = RouteData.Values[\"controller\"];\r\n        var action = RouteData.Values[\"action\"];\r\n            \r\n        id = (int)RouteData.Values[\"id\"];\r\n        name = (string)RouteData.Values[\"name\"];\r\n        standrdId = (int)RouteData.Values[\"standardId\"];\r\n\r\n        var area = RouteData.DataTokens[\"areaname\"];\r\n\r\n\r\n        return View();\r\n    }\r\n}',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,'2025-05-31 15:20:57','2025-05-31 15:31:21'),(4,3,NULL,'Create a  table','انشاء الجدول','sql','CREATE TABLE Students (\r\n    StudentID INT PRIMARY KEY,         -- This will automatically be Clustered Index\r\n    FullName NVARCHAR(100),\r\n    Email NVARCHAR(100),\r\n    PhoneNumber NVARCHAR(20)\r\n);',NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL,'2025-06-01 17:57:36','2025-06-01 18:14:05'),(5,3,NULL,'insert data','ادخال البيانات','text','INSERT INTO Students (StudentID, FullName, Email, PhoneNumber)\r\nVALUES \r\n(1, \'Ahmad Khaled\', \'ahmad@example.com\', \'0791234567\'),\r\n(2, \'Rana Ali\', \'rana@example.com\', \'0781112233\'),\r\n(3, \'Yousef Zaid\', \'yousef@example.com\', \'0773344556\'),\r\n(4, \'Sarah Odeh\', \'sarah@example.com\', \'0798765432\');',NULL,NULL,NULL,2,1,NULL,NULL,NULL,NULL,'2025-06-01 18:11:14','2025-06-01 18:14:05'),(6,3,NULL,'Create Non-Clustered Index','إنشاء Non-Clustered Index على الاسم','sql','CREATE NONCLUSTERED INDEX IX_Students_FullName\r\nON Students (FullName);',NULL,'What happens here:\r\n The system creates a B-Tree containing student names. Each name has a pointer to the actual class location, using the Clustered Key (StudentID).','اللي بصير هون:\r\n\r\nالنظام بعمل B-Tree فيه أسماء الطلاب.\r\n\r\nكل اسم فيه pointer لمكان الصف الفعلي، باستخدام الـ Clustered Key (StudentID).',2,1,NULL,NULL,NULL,NULL,'2025-06-01 18:11:14','2025-06-01 18:37:16'),(7,3,NULL,'create query and use the index','تنفيذ استعلام واستخدام الإندكس','text','Select * from Student\r\nwhere FullName= \"Sarah Odeh\";',NULL,'What happens behind the scenes? The Query Optimizer uses the B-Tree of the index. It searches for \'Sarah Odeh\' or \'Yousef Zaid\' very quickly (like searching a sorted dictionary). It finds the StudentID associated with the name (it\'s the Clustered Key). It then retrieves the rest of the data using the Clustered Index (this is called Key Lookup). ✅ Result: 🔹 Index Seek (fast) 🔹 Key Lookup (gets the rest of the columns) ❌ If there is no Non-Clustered Index: meaning there\'s no order for the name, what happens? What happens behind the scenes? The Query Optimizer can\'t find a suitable index. It says: \"I just have to search the rows one by one.\" 🔍 It runs a Table Scan → examines each row in the data until it finds the desired name. ❌\r\n Result: 🔻 Table Scan (very slow when there\'s a lot of data)','شو بصير بالكواليس؟\r\nالـ Query Optimizer بيستخدم الـ B-Tree تبع الإندكس.\r\n\r\nبيدور على \'Sarah Odeh\' أو \'Yousef Zaid\' بسرعة كبيرة (زي البحث في قاموس مرتب).\r\n\r\nبيطلع الـ StudentID المرتبط بالاسم (هو الـ Clustered Key).\r\n\r\nبيروح يجيب باقي البيانات باستخدام الـ Clustered Index (هاي اسمها Key Lookup).\r\n\r\n✅ النتيجة:\r\n🔹 Index Seek (سريع)\r\n🔹 Key Lookup (جيب باقي الأعمدة)\r\n\r\n❌ لو ما في Non-Clustered Index:\r\nيعني ما في ترتيب على الاسم، فشو بصير؟\r\n\r\nشو بصير بالكواليس؟\r\nالـ Query Optimizer ما بلاقي إندكس مناسب.\r\n\r\nبقول: \"ما في غير أروح أفتش الصفوف واحد واحد\" 🔍\r\n\r\nبيعمل Table Scan → يفحص كل صف بالداتا حتى يلاقي الاسم المطلوب.\r\n\r\n❌ النتيجة:\r\n🔻 Table Scan (بطيء جدًا لما تكون الداتا كثيرة)',3,1,NULL,NULL,NULL,NULL,'2025-06-01 18:11:14','2025-06-01 18:11:14'),(8,4,NULL,'Data Handling & Relationships Laravel (Eloquent):','تعامل مع البيانات وعلاقتها Laravel (Eloquent):','php','// Model: Post.php\r\npublic function comments() {\r\n    return $this->hasMany(Comment::class);\r\n}\r\n\r\n// Model: Comment.php\r\npublic function post() {\r\n    return $this->belongsTo(Post::class);\r\n}\r\n\r\n// usage\r\n$comments = Post::find(1)->comments;',NULL,'One-to-Many \r\nso eazy and there no need to manually define the columns if the labeling is correct.','العلاقة One-to-Many\r\nسهل جدًا  ولا حاجة لتعريف الأعمدة يدويًا إذا كانت التسمية صحيحة.',1,1,NULL,NULL,'<p><br></p>','<p>✅ أشياء في EF Core تشبه Eloquent:</p>','2025-06-08 13:24:05','2025-06-08 19:52:29'),(9,4,NULL,'Data Handling & Relationships .NET (EF Core):','تعامل مع البيانات وعلاقتهاNET (EF Core):','csharp','public class Post {\r\n    public int Id { get; set; }\r\n    public List<Comment> Comments { get; set; }\r\n}\r\n\r\npublic class Comment {\r\n    public int Id { get; set; }\r\n    public int PostId { get; set; }\r\n    public Post Post { get; set; }\r\n}\r\n\r\n// Context\r\nmodelBuilder.Entity<Comment>()\r\n    .HasOne(c => c.Post)\r\n    .WithMany(p => p.Comments)\r\n    .HasForeignKey(c => c.PostId);\r\n\r\n// usage\r\nvar comments = context.Posts\r\n    .Include(p => p.Comments)\r\n    .FirstOrDefault(p => p.Id == 1)?.Comments;',NULL,'EF Core – One to Many\r\nneed to know clearly epically when there campsite key or pivot tables','العلاقة One-to-Many\r\nتحتاج تعرف العلاقة بشكل أوضح خاصة لما يكون في مفتاح مركب أو جداول وسيطة',1,1,NULL,NULL,'<h1><strong>✅ Ease of Configuration:</strong></h1><h2> Laravel (Eloquent):</h2><h2> Setup is very simple and seamless.</h2><h2> Once you have the migration and model working.</h2><h2> relationships work automatically if they follow the naming conventions (such as user_id). </h2><p><br></p><h2>The pivot table is automatically created using naming. </h2><h2>NET EF Core: More complex, especially for complex relationships (many-to-many without an intermediate entity). You need to use modelBuilder inside OnModelCreating() in some cases to define keys and relationships. The pivot table here needs to be defined using .UsingEntity().</h2>','<h2>✅ <strong> سهولة الإعداد (Configuration):</strong>\r\nLaravel (Eloquent):\r\nالإعداد بسيط وسلس جدًا، بمجرد ما تعمل migration وmodel، العلاقات تشتغل بشكل أوتوماتيكي إذا اتبعت الـ naming conventions (مثل user_id). </h2><h2>ال pivot table بكون تلقائي باستخدام naming\r\n\r\n.NET EF Core:\r\nأكثر تعقيدًا، خصوصًا في العلاقات المعقدة (many-to-many بدون كيان وسيط). تحتاج تستخدم modelBuilder داخل OnModelCreating() في بعض الحالات لتحديد المفاتيح والعلاقات.</h2><h2>ال pivot table هون يحتاج تعريف باستخدام <code>.<strong>UsingEntity</strong>()</code></h2>','2025-06-08 14:25:06','2025-06-08 19:52:29'),(10,4,NULL,'usage view in laravel','استخدان الفيو  ب لارافل','php','//Controller\r\n\r\n$posts= Post::with(\'user\')->get();\r\nreturn view(posts.index,compact(\'posts\'))\r\n\r\n// in view\r\n@foreach ($posts as $post)\r\n    <h2>{{ $post->title }}</h2>\r\n    <p>{{ $post->content }}</p>\r\n    <small>Written by {{ $post->user->name }}</small>\r\n@endforeach',NULL,'Strengths: \r\nThe (user) relationship is ready in Eloquent. \r\nAccess is easy and straightforward via Blade. \r\nTypically, no null checks.','نقاط القوة:\r\n\r\nالعلاقة (user) جاهزة في Eloquent.\r\n\r\nالوصول سهل ومباشر عبر Blade.\r\n\r\nبدون null checks عادة.',2,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-08 21:52:51','2025-06-08 21:52:51'),(11,4,NULL,'view usage  in asp.net','استخدام الفيو ب الدوت نيت','text','// controller \r\nvar posts = await _context.Posts\r\n    .Include(p => p.User)\r\n    .ToListAsync();\r\n\r\nreturn View(posts);\r\n\r\n// view \r\n@model List<MyApp.Models.Post>\r\n\r\n@foreach (var post in Model)\r\n{\r\n    <h2>@post.Title</h2>\r\n    <p>@post.Content</p>\r\n    <small>Written by @post.User?.Name</small>\r\n}',NULL,'🔵 Notes:\r\n You must use @model above.\r\n Relationships need to be Include. You must ensure that User is not null (especially if you didn\'t use Include).','🔵 نقاط الملاحظة:\r\n\r\nلازم تعمل @model بالاعلى.\r\n\r\nالعلاقات تحتاج Include.\r\n\r\nلازم تتأكد إن User مش null (خصوصًا لو ما عملت Include).',3,1,NULL,NULL,'<h2>✅<strong> Laravel + Blade + Eloquent </strong>is more geared towards productivity and ease of work. </h2><h2>✅<strong> ASP.NET + Razor + EF Core</strong> provides greater power and control but requires more writing and thinking.</h2>','<h2>✅ <strong>Laravel + Blade + Eloquent</strong> موجه أكثر للإنتاجية وسهولة العمل </h2><p> الـ View✅ <strong>ASP.NET + Razor + EF Core</strong> يوفر قوة وتحكم أكبر لكن يحتاج كتابة وتفكير أكثر</p>','2025-06-08 21:52:51','2025-06-08 21:52:51'),(12,5,NULL,'input button vs Button element','input button vs Button element','html','<!-- Input button -->\r\n<input type=\"button\" value=\"Click me\" class=\"btn-primary\" style=\"background-color: blue; color: white;\">\r\n\r\n<!-- Button element -->\r\n<button type=\"submit\" class=\"btn btn-primary\" style=\"background-color: blue; color: white;\">\r\n  Click me <span class=\"icon-arrow\"></span>\r\n</button>',NULL,'Here, the <button> element can contain additional elements, like a span with an icon, while <input type=\"button\"> is limited to plain text.\r\n\r\nSo if you need basic functionality, <input type=\"button\"> works fine. But for greater control over styling and content, <button> is the better choice!','هون العنصر  <button> بقدر يحتوي ع العناصر اضافيه زي span with an icon \r\nانما  <input type=\"button\"> محدود بالنص.\r\nاذا بدك وظاىف اساسيه اختار ال <input type=\"button\">\r\nاما اذا بدك تجكم اكثر بالستايل وايكون اكثر زي الصور  ع شكلbutton اختار <button>',1,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-10 13:44:00','2025-06-10 13:44:00'),(13,6,NULL,'Primary Key','مفتاح Primary','sql','CREATE TABLE Employee (\r\nemployee_id INT PRIMARY KEY, -- Uniquely identifies each employee\r\nFirst_Name VARCHAR (50), \r\nLast_Name VARCHAR (50)\r\n);',NULL,'A Primary Key is a column (or a set of columns) that uniquely identifies each row in a table. It cannot contain duplicate or NULL values.','المفتاح الأساسي هو عمود (أو مجموعة أعمدة) يُعرّف كل صف في الجدول بشكل فريد. لا يمكن أن يحتوي على قيم مكررة أو فارغة.',1,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-10 15:19:03','2025-06-10 15:19:03'),(14,6,NULL,'Foreigen key','المفتاح الخارجي','sql','CREATE TABLE Departments (\r\n    department_id   INT PRIMARY KEY,\r\n    department_name VARCHAR(100)\r\n);\r\n\r\nCREATE TABLE Employees (\r\n    employee_id   INT PRIMARY KEY,\r\n    first_name    VARCHAR(50),\r\n    last_name     VARCHAR(50),\r\n    department_id INT,\r\n    FOREIGN KEY (department_id) REFERENCES Departments(department_id)\r\n);',NULL,'A Foreign Key is a column (or a group of columns) in one table that references the primary key in another table. This establishes a relationship between tables and enforces referential integrity.','المفتاح الخارجي هو عمود (أو مجموعة أعمدة) في جدول يُشير إلى المفتاح الأساسي في جدول آخر. يُنشئ هذا علاقة بين الجداول ويضمن سلامة المرجع.',2,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-10 15:52:59','2025-06-10 15:52:59'),(15,6,NULL,'Unique Key','مفتاح الفريد','sql','CREATE TABLE users (\r\nuser_id INT PRIMARY KEY\r\nUserName VARCHAR (50) UNIQUE,\r\nEMAIL VARCHAR (50) UNIQUE\r\n);',NULL,'A Unique Key ensures that all the values in a column (or a combination of columns) are distinct. Unlike the primary key, a unique key column may allow a single NULL (depending on the DBMS).','يضمن المفتاح الفريد تميز جميع القيم في عمود (أو مجموعة أعمدة). بخلاف المفتاح الأساسي، قد يسمح عمود المفتاح الفريد بـ NULL واحد (حسب نظام إدارة قاعدة البيانات).',3,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-10 15:52:59','2025-06-10 15:52:59'),(16,6,NULL,'Candidate Key',NULL,'sql','CREATE TABLE Users (\r\n    user_id  INT,            -- Candidate Key 1\r\n    username VARCHAR(50),    -- Candidate Key 2\r\n    email    VARCHAR(100),   -- Candidate Key 3\r\n    PRIMARY KEY (user_id),   -- Chosen as the Primary Key\r\n    UNIQUE (username),       -- Alternate Key (remaining candidate)\r\n    UNIQUE (email)           -- Alternate Key (remaining candidate)\r\n);',NULL,'A Candidate Key is any column (or combination of columns) that can uniquely identify a row. A table can have multiple candidate keys. One of these is chosen as the primary key, and the others are known as alternate keys.','المفتاح المُرشَّح هو أي عمود (أو مجموعة أعمدة) يُحدِّد صفًا بشكل فريد. يمكن أن يحتوي الجدول على عدة مفاتيح مُرشَّحة. يُختار أحدها كمفتاح أساسي، وتُعرف المفاتيح الأخرى بالمفاتيح البديلة.',4,1,NULL,NULL,'<p>Alternate Key</p><p>An <strong>Alternate Key</strong> is simply a candidate key that was not selected as the primary key. In the previous example, both <code>username</code> and <code>email</code> are alternate keys.</p><p><strong>Example Explanation:</strong></p><ul><li>In the <code>Users</code> table above, since <code>user_id</code> is used as the primary key, <code>username</code> and <code>email</code> serve as alternate keys.</li></ul><p><br></p>','<p>المفتاح البديل هو ببساطة <strong>مفتاح مرشح</strong> لم يُختر كمفتاح أساسي. في المثال السابق، كلٌّ من اسم  </p>','2025-06-10 15:52:59','2025-06-10 15:54:45'),(17,6,NULL,'Composite Key','مفتاح مركب','sql','CREATE TABLE OrderDetails (\r\n    order_id   INT,\r\n    product_id INT,\r\n    quantity   INT,\r\n    PRIMARY KEY (order_id, product_id)  -- Composite key made of two columns\r\n);',NULL,'A Composite Key is a primary key that consists of more than one column. The combination of these columns is used to uniquely identify a row.','المفتاح المركب هو مفتاح أساسي يتكون من أكثر من عمود. يُستخدم دمج هذه الأعمدة لتحديد صف فريد.',5,1,NULL,NULL,'<p><br></p>','<p><br></p>','2025-06-10 15:52:59','2025-06-10 15:52:59'),(18,6,NULL,'Super Key','المفتاح السوبر','sql','CREATE TABLE Students (\r\n    student_id INT,\r\n    name       VARCHAR(50),\r\n    age        INT,\r\n    PRIMARY KEY (student_id)\r\n);',NULL,'A Super Key is any combination of columns that uniquely identifies a row in a table. It might include extra columns that are not necessary for unique identification (i.e., it may not be minimal).','أي تركيبة أعمدة بتميز الصفوف، حتى لو فيها أعمدة زايدة.',6,1,NULL,NULL,'<p>notes outlining each type of key in SQL databases:</p><p><strong>Primary Key</strong></p><ul><li><strong>Uniqueness:</strong> Must be unique for every record and cannot accept NULL values.</li><li><strong>Identity:</strong> Acts as the main column representing the identity of the table.</li><li><strong>Note:</strong> Typically, only one primary key is chosen per table.</li></ul><p><strong>Foreign Key</strong></p><ul><li><strong>Relationship:</strong> Used to link different tables by referencing the primary key of another table.</li><li><strong>Referential Integrity:</strong> Ensures the integrity between tables is maintained.</li><li><strong>Note:</strong> When deleting or updating records in the related table, handling policies (such as CASCADE or RESTRICT) must be considered.</li></ul><p><strong>Unique Key</strong></p><ul><li><strong>Distinct Values:</strong> Ensures that the values in a column (or a combination of columns) are not duplicated. It is similar to a primary key but may allow a NULL value, depending on the DBMS.</li><li><strong>Note:</strong> Allows you to specify a column or set of columns for ensuring data uniqueness without setting it as the primary key.</li></ul><p><strong>Candidate Key</strong></p><ul><li><strong>Definition:</strong> Any set of columns that has the ability to uniquely identify a record in the table.</li><li><strong>Multiple Options:</strong> A table can have more than one candidate key. One candidate is chosen as the primary key, while the others are referred to as alternate keys.</li><li><strong>Note:</strong> A candidate key is a minimal version of a super key, meaning it does not include any extra columns that are not necessary.</li></ul><p><strong>Alternate Key</strong></p><ul><li><strong>Definition:</strong> Candidate keys that were not chosen to be the primary key.</li><li><strong>Note:</strong> They retain the same properties of candidate keys and are important for providing additional options for ensuring uniqueness.</li></ul><p><br></p><p><strong>Composite Key</strong></p><ul><li><strong>Combination:</strong> Consists of more than one column together to uniquely identify a record.</li><li><strong>Note:</strong> Used when a single column is not sufficient to uniquely identify a record.</li></ul><p><strong>Super Key</strong></p><ul><li><strong>Broad Uniqueness:</strong> Any combination of columns that guarantees the uniqueness of each record, even if it includes extra columns that are not necessary for unique identification.</li><li><strong>Note:</strong> Every candidate key is a super key, but not every super key qualifies as a candidate key because it might include additional, non-essential columns.</li></ul><p>In summary, these notes are the essential points you need to know when documenting or outlining the types of keys in SQL. They help clarify the distinct differences and the specific uses of each key type in designing a robust database.</p><p><br></p>','<p>خلينا نوضح الموضوع بالملاحظات (NOTES) الأساسية يلي لازم تذكرها لكل نوع من أنواع الـ keys في قواعد البيانات:</p><p><strong>المفتاح الأساسي (Primary Key):</strong></p><p class=\"ql-indent-1\">لازم يكون فريد لكل سجل وما يقبل قيمة NULL.</p><p class=\"ql-indent-1\">هو العمود الرئيسي يلي تمثّل هوية الجدول.</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> عادةً بنختار مفتاح أساسي واحد لكل جدول.</p><p><strong>المفتاح الخارجي (Foreign Key):</strong></p><p class=\"ql-indent-1\">يستخدم لربط جداول مختلفة من خلال الإشارة للمفتاح الأساسي بجدول تاني.</p><p class=\"ql-indent-1\">يلزم لفرض التكامل المرجعي بين الجداول.</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> لما يكون في حذف أو تعديل بالجدول المرتبط، لازم تُراعى سياسات التعامل (مثل CASCADE أو RESTRICT).</p><p><strong>المفتاح الفريد (Unique Key):</strong></p><p class=\"ql-indent-1\">يضمن عدم تكرار القيم في العمود، مماثل للمفتاح الأساسي لكن ممكن يقبل قيمة NULL (حسب نظام إدارة قاعدة البيانات).</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> يسمح لك بتحديد عمود أو مجموعة أعمدة تضمن تفرد البيانات بدون تعيينها كمفتاح أساسي.</p><p><strong>المفتاح المرشح (Candidate Key):</strong></p><p class=\"ql-indent-1\">هو أي مجموعة من الأعمدة يلي فيهم إمكانية تحديد السجل بشكل فريد.</p><p class=\"ql-indent-1\">ممكن يكون في أكثر من مفتاح مرشح بكل جدول، واختار واحد منهم يكون المفتاح الأساسي والباقي يسميّوا مفاتيح بديلة (Alternate Keys).</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> المفتاح المرشح هو نسخة مصغرة (minimal) لمفتاح سوبر، بدون أي عمود زايد.</p><p><strong>المفتاح البديل (Alternate Key):</strong></p><p class=\"ql-indent-1\">هي المفاتيح المرشحة يلي ما اخترناها كمفتاح أساسي.</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> تبقى بنفس خصائص المفتاح المرشح، وهي مهمة لو حابّين نحتفظ بخيارات إضافية للتفرد.</p><p><strong>المفتاح المركب (Composite Key):</strong></p><p class=\"ql-indent-1\">يتكوّن من أكثر من عمود مع بعض لتحديد السجل بشكل فريد.</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> يُستخدم لما ما يكون عمود واحد كافي لتحديد السجل.</p><p><strong>المفتاح السوبر (Super Key):</strong></p><p class=\"ql-indent-1\">هو أي مجموعة من الأعمدة بتضمن التفرد في كل سجل، حتى لو فيها أعمدة زايدة وغير ضرورية للتفرد.</p><p class=\"ql-indent-1\"><strong>ملاحظة:</strong> أي مفتاح مرشح يعتبر مفتاح سوبر، لكن مش كل مفتاح سوبر هو مفتاح مرشح لأنه ممكن يحتوي على بيانات إضافية مش ضرورية.</p><p>باختصار، هاي الملاحظات هي النقاط الأساسية يلي لازم تعرفها وتذكرها عند توثيق أو وضع ملاحظات عن أنواع المفاتيح (keys) في SQL. هي بتساعدك تفهم الفرق الواضح بين كل نوع واستخداماته بالتصميم الصحيح لقواعد البيانات.</p>','2025-06-10 15:52:59','2025-06-10 16:15:20');
/*!40000 ALTER TABLE `code_snippets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comparison_tables`
--

DROP TABLE IF EXISTS `comparison_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comparison_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `table_data` json NOT NULL,
  `table_data_en` json DEFAULT NULL,
  `table_data_ar` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `show_header` tinyint(1) NOT NULL DEFAULT '1',
  `show_borders` tinyint(1) NOT NULL DEFAULT '1',
  `striped_rows` tinyint(1) NOT NULL DEFAULT '1',
  `table_style` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comparison_tables_article_id_foreign` (`article_id`),
  CONSTRAINT `comparison_tables_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comparison_tables`
--

LOCK TABLES `comparison_tables` WRITE;
/*!40000 ALTER TABLE `comparison_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `comparison_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date_translations`
--

DROP TABLE IF EXISTS `date_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `date_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_translations_type_key_locale_unique` (`type`,`key`,`locale`),
  KEY `date_translations_type_locale_index` (`type`,`locale`),
  KEY `date_translations_key_locale_index` (`key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date_translations`
--

LOCK TABLES `date_translations` WRITE;
/*!40000 ALTER TABLE `date_translations` DISABLE KEYS */;
INSERT INTO `date_translations` VALUES (1,'day','Monday','ar','الاثنين',1,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(2,'day','Monday','en','Monday',1,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(3,'day','Tuesday','ar','الثلاثاء',2,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(4,'day','Tuesday','en','Tuesday',2,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(5,'day','Wednesday','ar','الأربعاء',3,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(6,'day','Wednesday','en','Wednesday',3,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(7,'day','Thursday','ar','الخميس',4,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(8,'day','Thursday','en','Thursday',4,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(9,'day','Friday','ar','الجمعة',5,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(10,'day','Friday','en','Friday',5,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(11,'day','Saturday','ar','السبت',6,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(12,'day','Saturday','en','Saturday',6,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(13,'day','Sunday','ar','الأحد',7,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(14,'day','Sunday','en','Sunday',7,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(15,'month','January','ar','يناير',1,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(16,'month','January','en','January',1,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(17,'month','February','ar','فبراير',2,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(18,'month','February','en','February',2,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(19,'month','March','ar','مارس',3,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(20,'month','March','en','March',3,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(21,'month','April','ar','أبريل',4,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(22,'month','April','en','April',4,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(23,'month','May','ar','مايو',5,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(24,'month','May','en','May',5,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(25,'month','June','ar','يونيو',6,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(26,'month','June','en','June',6,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(27,'month','July','ar','يوليو',7,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(28,'month','July','en','July',7,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(29,'month','August','ar','أغسطس',8,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(30,'month','August','en','August',8,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(31,'month','September','ar','سبتمبر',9,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(32,'month','September','en','September',9,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(33,'month','October','ar','أكتوبر',10,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(34,'month','October','en','October',10,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(35,'month','November','ar','نوفمبر',11,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(36,'month','November','en','November',11,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(37,'month','December','ar','ديسمبر',12,'2025-05-30 20:51:17','2025-05-30 20:51:17'),(38,'month','December','en','December',12,'2025-05-30 20:51:17','2025-05-30 20:51:17');
/*!40000 ALTER TABLE `date_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_05_23_203740_create_categories_table',1),(5,'2025_05_23_203743_create_articles_table',1),(6,'2025_05_24_130102_create_date_translations_table',1),(7,'2025_05_24_181634_create_summaries_table',1),(8,'2025_05_25_155144_fix_summaries_table_charset',1),(9,'2025_05_25_173307_add_bilingual_titles_to_articles_table',1),(10,'2025_05_25_212614_fix_articles_foreign_key_constraint',1),(11,'2025_05_25_212743_add_soft_deletes_to_articles_table',1),(12,'2025_05_26_182809_create_code_snippets_table',1),(13,'2025_05_31_000000_add_article_relationships',2),(16,'2025_05_31_193042_create_summary_categories_table',3),(17,'2025_05_31_193158_add_category_slug_to_summaries_table',3),(18,'2025_06_01_235747_create_article_views_table',4),(19,'2025_06_03_005144_make_code_snippets_completely_optional',5),(20,'2025_06_03_005536_add_parent_id_to_categories_table',6),(21,'2025_06_08_174920_add_content_after_to_code_snippets_table',7),(22,'2025_06_08_185713_create_comparison_tables_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `related_articles`
--

DROP TABLE IF EXISTS `related_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `related_articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_id` bigint unsigned NOT NULL,
  `related_article_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `related_articles_article_id_foreign` (`article_id`),
  KEY `related_articles_related_article_id_foreign` (`related_article_id`),
  CONSTRAINT `related_articles_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `related_articles_related_article_id_foreign` FOREIGN KEY (`related_article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `related_articles`
--

LOCK TABLES `related_articles` WRITE;
/*!40000 ALTER TABLE `related_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `related_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('3B2Plmn6OyVWWQ88U6xlfzH6WKBben5wdNsWzfRo',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicE9qb2R4RkVEdk9nRDI4S0JFSnl2WW9ZcU1WTnhKcExIVXJnV25VbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1749850973),('IyJLnyzW6XTAirrnAXJ6ygcwjVCPZrlmHEuVeGQg',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOG5yYzFiMmJUM3ExUWdIaUNaazBodzFjYzRqdkJWVG9xQTRESHlHWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hYm91dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoibG9jYWxlIjtzOjI6ImVuIjt9',1749833558);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summaries`
--

DROP TABLE IF EXISTS `summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `summaries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_scheme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blue',
  `published_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `summaries_category_slug_foreign` (`category_slug`),
  CONSTRAINT `summaries_category_slug_foreign` FOREIGN KEY (`category_slug`) REFERENCES `summary_categories` (`slug`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summaries`
--

LOCK TABLES `summaries` WRITE;
/*!40000 ALTER TABLE `summaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summary_categories`
--

DROP TABLE IF EXISTS `summary_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `summary_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blue',
  `icon` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `summary_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summary_categories`
--

LOCK TABLES `summary_categories` WRITE;
/*!40000 ALTER TABLE `summary_categories` DISABLE KEYS */;
INSERT INTO `summary_categories` VALUES (1,'API World','عالم الـ API','api','API development, REST, GraphQL and web services','تطوير الـ API، REST، GraphQL وخدمات الويب','blue','<path d=\"M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z\"/>',10,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(2,'Git and Beyond','الـ Git وما وراءه','git','Version control, Git workflows and collaboration','إدارة الإصدارات، سير عمل Git والتعاون','orange','<path d=\"M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z\"/>',20,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(3,'Advanced Programming','متقدم','advanced','Advanced programming concepts and techniques','مفاهيم وتقنيات البرمجة المتقدمة','purple','<path d=\"M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z\"/>',30,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(4,'Books','الكتب','books','Programming books summaries and reviews','ملخصات ومراجعات كتب البرمجة','green','<path d=\"M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h6v-2H6V4h9v5h5v11h-5v2h5a2 2 0 0 0 2-2V8l-6-6H6z\"/>',40,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(5,'Courses','الكورسات','courses','Online courses and learning materials','الكورسات الأونلاين ومواد التعلم','yellow','<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"/>',50,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(6,'Documentation','التوثيق','documentation','Project documentation and technical writing','توثيق المشاريع والكتابة التقنية','emerald','<path d=\"M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 4h7v5h5v11H6V4z\"/>',60,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(7,'Frameworks','أطر العمل','frameworks','Frontend and backend frameworks','أطر عمل الواجهات الأمامية والخلفية','cyan','<path d=\"M12 0L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5z\"/>',70,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(8,'Databases','قواعد البيانات','databases','Database design, SQL and NoSQL','تصميم قواعد البيانات، SQL وNoSQL','yellow','<path d=\"M12 2C9.243 2 7 2.895 7 4v2c0 1.105 2.243 2 5 2s5-.895 5-2V4c0-1.105-2.243-2-5-2zM7 8v2c0 1.105 2.243 2 5 2s5-.895 5-2V8c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 12v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2zM7 16v2c0 1.105 2.243 2 5 2s5-.895 5-2v-2c0 1.105-2.243 2-5 2s-5-.895-5-2z\"/>',80,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(9,'Security','الأمان','security','Cybersecurity and application security','الأمن السيبراني وأمان التطبيقات','red','<path d=\"M12 2L3 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-9-5zM10 17l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z\"/>',90,1,'2025-05-31 16:33:18','2025-05-31 16:33:18'),(10,'DevOps','الـ DevOps','devops','CI/CD, containerization and cloud deployment','CI/CD، الحاويات ونشر السحابة','indigo','<path d=\"M12 2L2 7v10c0 5.55 3.84 9.74 9 10 5.16-.26 9-4.45 9-10V7l-10-5z\"/>',100,1,'2025-05-31 16:33:18','2025-05-31 16:33:18');
/*!40000 ALTER TABLE `summary_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@example.com',NULL,'$2y$12$A9lbaaZ/45mFucJOzkZtLeMd.a.MS4Uu/bjA/ZUS3ecvcGj2izfzW',NULL,'2025-05-30 20:51:43','2025-05-30 20:51:43'),(2,'Admin','osamaayeshdx@gmail.com',NULL,'$2y$12$/MGOxDoTX5kmkKRI9ND6CuHSmJdFVmsGgii2FFnJa7kZEK2ynGMlK',NULL,'2025-05-30 20:51:43','2025-05-30 20:51:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-14 14:12:52
