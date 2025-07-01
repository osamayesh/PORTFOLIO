@echo off
echo ====================================
echo     PDF Summaries Upload Tool
echo ====================================
echo.

REM Check if storage directory exists
if not exist "storage\app\public\pdfs" (
    echo Creating pdfs directory...
    mkdir "storage\app\public\pdfs"
    echo Directory created!
    echo.
)

echo Current PDF files in storage:
echo.
dir "storage\app\public\pdfs\*.pdf" /b 2>nul
if errorlevel 1 (
    echo No PDF files found.
)
echo.

echo Options:
echo 1. Copy PDFs from Desktop
echo 2. Copy PDFs from Downloads
echo 3. Copy from custom location
echo 4. Import existing PDFs to database
echo 5. View upload guide
echo 6. Exit
echo.

set /p choice="Choose an option (1-6): "

if "%choice%"=="1" (
    echo Copying PDFs from Desktop...
    copy "%USERPROFILE%\Desktop\*.pdf" "storage\app\public\pdfs\" 2>nul
    if errorlevel 1 (
        echo No PDF files found on Desktop.
    ) else (
        echo PDFs copied from Desktop!
    )
    goto import
)

if "%choice%"=="2" (
    echo Copying PDFs from Downloads...
    copy "%USERPROFILE%\Downloads\*.pdf" "storage\app\public\pdfs\" 2>nul
    if errorlevel 1 (
        echo No PDF files found in Downloads.
    ) else (
        echo PDFs copied from Downloads!
    )
    goto import
)

if "%choice%"=="3" (
    set /p source_path="Enter the full path to your PDF files: "
    if exist "%source_path%" (
        copy "%source_path%\*.pdf" "storage\app\public\pdfs\" 2>nul
        if errorlevel 1 (
            echo No PDF files found in specified location.
        ) else (
            echo PDFs copied from %source_path%!
        )
        goto import
    ) else (
        echo Path does not exist: %source_path%
        pause
        exit /b
    )
)

if "%choice%"=="4" (
    goto import
)

if "%choice%"=="5" (
    echo Opening upload guide...
    start notepad "UPLOAD_GUIDE.md"
    exit /b
)

if "%choice%"=="6" (
    exit /b
)

echo Invalid choice. Please try again.
pause
exit /b

:import
echo.
echo Now importing PDFs to database...
echo.
echo Choose import mode:
echo 1. Interactive mode (recommended)
echo 2. Auto mode (quick)
echo.
set /p import_choice="Choose mode (1-2): "

if "%import_choice%"=="1" (
    php artisan summaries:import
) else if "%import_choice%"=="2" (
    php artisan summaries:import --auto
) else (
    echo Invalid choice, using interactive mode...
    php artisan summaries:import
)

echo.
echo Upload process completed!
echo You can now view your summaries on the website.
pause 