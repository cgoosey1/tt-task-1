## TT Task 2
This task involves creating a simple profile searching system, assuming you have a database setup matching the format
you can run this application using `php -S localhost:8000`.

This is a very quick and dirty MVC framework with bare minimum functionality.

Database format:

profiles
 - UserRefID (int)
 - Firstname (varchar 255)
 - Surname (varchar 255)
 - Deceased (tinyInt default 0)

emails
 - emailID (int)
 - UseRefID (int)
 - emailaddress (varchar 255)
 - Default (tinyInt default 0)

This has all been developed on PHP 8.2