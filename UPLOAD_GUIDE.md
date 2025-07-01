# 📚 PDF Summaries Upload Guide

This guide explains how to upload PDF files to your summaries system without needing an admin panel.

## 📂 Directory Structure

Your PDF files should be placed in:
```
storage/app/public/pdfs/
```

This directory is accessible via:
```
public/storage/pdfs/
```

## 🚀 How to Upload Files

### Step 1: Copy PDF Files
1. Copy your PDF files to: `storage/app/public/pdfs/`
2. Name your files descriptively (the system will auto-detect categories)

### Step 2: Import to Database
Run one of these commands:

#### Interactive Mode (Recommended)
```bash
php artisan summaries:import
```
This will:
- Show you all new PDF files
- Ask for titles in English and Arabic
- Ask for descriptions
- Let you choose categories
- Let you choose color schemes

#### Auto Mode (Quick)
```bash
php artisan summaries:import --auto
```
This will:
- Auto-detect categories from filenames
- Generate basic titles and descriptions
- Assign random color schemes

## 📋 Categories Available

- `api` - API World
- `git` - Git and Version Control
- `advanced` - Advanced Programming
- `books` - Books
- `courses` - Courses
- `documentation` - Documentation
- `research` - Research

## 🎨 Color Schemes Available

- `blue` - Blue Theme
- `green` - Green Theme
- `purple` - Purple Theme
- `orange` - Orange Theme
- `red` - Red Theme
- `yellow` - Yellow Theme
- `pink` - Pink Theme
- `indigo` - Indigo Theme

## 💡 File Naming Tips

For auto-detection to work better, include keywords in your filenames:

- `api_guide.pdf` → Will be categorized as "api"
- `git_commands.pdf` → Will be categorized as "git"
- `book_clean_code.pdf` → Will be categorized as "books"
- `course_laravel.pdf` → Will be categorized as "courses"
- `advanced_patterns.pdf` → Will be categorized as "advanced"

## 📁 Example File Structure

```
storage/app/public/pdfs/
├── api_rest_guide.pdf
├── git_commands_cheatsheet.pdf
├── book_clean_code_summary.pdf
├── course_laravel_basics.pdf
├── advanced_design_patterns.pdf
└── documentation_docker_guide.pdf
```

## 🔧 Troubleshooting

### Files not showing up on website?
1. Make sure storage link exists: `php artisan storage:link`
2. Check file permissions
3. Verify files are in `storage/app/public/pdfs/`

### Import command not working?
1. Make sure you're in the project directory
2. Check database connection
3. Ensure Summary model exists

### PDF viewer not working?
1. Check if PDF files are accessible via browser: `yoursite.com/storage/pdfs/filename.pdf`
2. Verify the `pdf_file_path` in database matches actual filename

## 🎯 Quick Start Example

1. Copy a PDF file to `storage/app/public/pdfs/my_api_guide.pdf`
2. Run: `php artisan summaries:import`
3. Follow the prompts to add titles and descriptions
4. Visit your summaries page to see the new file

## 📞 Need Help?

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database connection
3. Make sure all dependencies are installed
4. Check file permissions on storage directories 