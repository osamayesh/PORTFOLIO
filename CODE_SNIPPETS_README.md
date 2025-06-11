# Code Snippets Feature for Articles

This feature allows you to add and manage code snippets within your articles from the admin dashboard.

## Features

- ✅ **Multi-language Support**: Add titles and descriptions in both English and Arabic
- ✅ **Syntax Highlighting**: Support for multiple programming languages (C, C++, Java, Python, JavaScript, PHP, HTML, CSS, SQL, Bash, JSON, XML)
- ✅ **Line Numbers**: Optional line numbers display
- ✅ **File Names**: Optional filename display
- ✅ **Copy to Clipboard**: One-click code copying
- ✅ **Multiple Snippets**: Add multiple code snippets to a single article
- ✅ **Ordering**: Control the order of snippets within an article
- ✅ **Responsive Design**: Works on all devices

## How to Use

### Creating Articles with Code Snippets

1. **Go to Admin Dashboard** → Articles → Create New Article
2. **Fill in the basic article information** (title, content, etc.)
3. **In the Code Snippets section**:
   - Click "**+ Add Snippet**" to add a new code snippet
   - Fill in the details:
     - **Title (English/Arabic)**: Optional title for the code snippet
     - **Language**: Select the programming language for syntax highlighting
     - **Order**: Number to control the display order (0 = first)
     - **Filename**: Optional filename to display above the code
     - **Description (English/Arabic)**: Optional description explaining the code
     - **Code**: The actual code content
     - **Show line numbers**: Check to display line numbers
   - Click "**Remove**" to delete a snippet
   - Click "**+ Add Snippet**" again to add more snippets

4. **Save the article**

### Editing Articles with Code Snippets

1. **Go to Admin Dashboard** → Articles → Edit (existing article)
2. **The Code Snippets section will show existing snippets**
3. **You can**:
   - Edit existing snippets
   - Add new snippets
   - Remove snippets
   - Reorder snippets
4. **Save changes**

### Viewing Articles with Code Snippets

When visitors view your article on the public site, they will see:
- Code snippets with syntax highlighting
- Copy button for each snippet
- Line numbers (if enabled)
- Filename header (if provided)
- Snippet title and description (if provided)

## Supported Programming Languages

- **C** (`c`)
- **C++** (`cpp`)
- **Java** (`java`)
- **Python** (`python`)
- **JavaScript** (`javascript`)
- **PHP** (`php`)
- **HTML** (`html`)
- **CSS** (`css`)
- **SQL** (`sql`)
- **Bash** (`bash`)
- **JSON** (`json`)
- **XML** (`xml`)
- **Plain Text** (`text`)

## Database Structure

The code snippets are stored in a separate `code_snippets` table with the following fields:

- `id`: Primary key
- `article_id`: Foreign key to the articles table
- `title`, `title_en`, `title_ar`: Snippet titles
- `language`: Programming language identifier
- `code`: The actual code content
- `description`, `description_en`, `description_ar`: Optional descriptions
- `order`: Display order within the article
- `show_line_numbers`: Boolean for line numbers display
- `filename`: Optional filename
- `created_at`, `updated_at`: Timestamps

## Technical Implementation

### Models
- `CodeSnippet` model with localization helpers
- `Article` model updated with `codeSnippets()` relationship

### Controllers
- `Admin\ArticleController` updated to handle code snippet CRUD operations
- `ArticleController` updated to load code snippets when displaying articles

### Views
- Admin forms with dynamic JavaScript for adding/removing snippets
- Article detail view updated to display code snippets with Prism.js

### JavaScript Libraries
- **Prism.js** for syntax highlighting
- **Copy to clipboard** functionality
- **Dynamic form management** for adding/removing snippets in admin

## CSS Styling

The code snippets use a dark theme with:
- Dark gray background (`#1a202c`)
- Syntax highlighting via Prism.js themes
- Copy button with hover effects
- Responsive design for mobile devices
- Line numbers styling
- Filename header styling

## Example Usage

```php
// Creating a new article with code snippets programmatically
$article = Article::create([
    'title_en' => 'My Programming Tutorial',
    'title_ar' => 'درس البرمجة الخاص بي',
    // ... other article fields
]);

// Add a code snippet
$article->codeSnippets()->create([
    'title_en' => 'Hello World Example',
    'title_ar' => 'مثال مرحبا بالعالم',
    'language' => 'c',
    'code' => '#include <stdio.h>\n\nint main() {\n    printf("Hello, World!");\n    return 0;\n}',
    'description_en' => 'A simple Hello World program in C',
    'description_ar' => 'برنامج بسيط لطباعة مرحبا بالعالم بلغة سي',
    'order' => 0,
    'show_line_numbers' => true,
    'filename' => 'hello.c'
]);
``` 