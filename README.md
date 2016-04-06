## Synopsis

**Scan Bank** is a PHP-based Web Platform for Managing Courses' Scans for Universities.
The platform is being used at Tel Aviv University and already contains more than 500 Courses Materials.

## See it Live

@ [Tel Aviv University Scan Bank](http://www.taupdf.com)

## Motivation

Tel Aviv University is known for its very poor effort in sharing study material across students.
So, instead of using Dropbox or other file sharing services - I've developed a dedicated Web Platform for Uploading, Sharing, and Ranking Study Materials which every student can upload and view.

## Installation

Unfourtanetly, this is not a one-click-installation type of thing.
This platform uses some Linux apps that has to be installed in order for it to work as expected.
There are 8 steps that you need to take care of:

1. First, copy all the files to your www directory (must be a linux servers running at least CentOs 6.6).
2. Install PHP (Minimum version: 5.5).
 2.1 In php.ini set upload_max_size to at least 200M (or the biggest filesize you think students will upload).
 2.2 In php.ini set memory_limit to at least 256M.
3. Install GPL Ghostscript 8.70 (in order to compress PDF files automatically).
4. Install LibreOffice 4.0.4.2 (in order to convert non-PDF files to PDF).
5. Install ImageMagick 6.9.0-2.
6. Install MySQL Database, and run "install.sql"'s content as an SQL query to create the needed structure.
7. Edit the connection credentials in **db.php** to match your Database.
8. Change chmod permissions to 777 for the **upload** directory.

## Contributors

Coffee.

## License

You are free to use the code for personal/commercial use, no license needed.
