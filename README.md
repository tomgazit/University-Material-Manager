## Synopsis

**University Material Manager** is a PHP-based Web Platform for Managing & **Sharing** University Courses' Study Materials across students.
Anyone can register and start upload study materials (Lectures, Recitations, Formula Sheets.. etc), and assign each one to a specific course and faculty.
Each registered user gets a fancy [Control Panel](http://www.tomgazit.com/controlpanel.png) with which he may add/edit/remove uploaded materials.

* Fully Responsive Design (for Desktop & Mobile)
* DOC/DOCX files are automatically converted to PDFs
* Pages can be reordered easily
* Pages can be added to each upload
* Lots of AJAXs for best UX
* Convenient Control Panel for each user

The platform is being used at Tel Aviv University and already contains more than 500 Courses Materials.

## Motivation

Tel Aviv University is known for its very poor effort for sharing study material across students.
So, rather of using Dropbox or other file sharing services - I've developed a university-dedicated Web Platform for Uploading, Sharing, and Ranking Study Materials which every student can use.

## Installation

Unfortunately, this is not a one-click-installation type of thing.
This platform uses some Linux apps that has to be installed in order for it to work as expected.
There are 9 steps that you need to take care of:

1. First, copy all the files to your www directory (must be a linux server running at least CentOs 6.6).
2. Install PHP (Minimum version: 5.5).
 * In php.ini set upload_max_size to at least 200M (or the biggest filesize you think students will upload).
 * In php.ini set memory_limit to at least 256M.
3. Install GPL Ghostscript 8.70 (in order to compress PDF files automatically).
4. Install LibreOffice 4.0.4.2 (in order to convert non-PDF files to PDF).
5. Install ImageMagick 6.9.0-2.
6. Install MySQL Database, and run "install.sql"'s content as an SQL query to create the needed structure.
7. Edit the connection credentials in **db.php** to match your Database.
8. Change chmod permissions to 777 for the **upload** directory.
9. PROFIT ;)

## Contributors

Coffee.

## License

MIT License.

**SPREAD THE KNOWLEDGE !**
