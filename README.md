Nexus, a PHP-based, MVC-inspired CMF
====================================

This project is used while teaching advanced PHP-programming with Model View Controller (MVC)
frameworks with a taste of Content Management Framework (CMF). 


Installation
------------

Download the source code from http://www.github.com/BadCash/nexus and copy it to your webserver.
Then visit the following URL in your browser: <url_to_nexus>/installer
This will take you through the installation process.


Customization
-------------

**Changing the look of Nexus**

To make changes to the look of Nexus, simply locate the file config.php inside the site/ folder.
At the very bottom of this file you will find the sections where you can edit the header, slogan
favicon, logo and footer. Simply make the necessary changes here and save the file.

Note that the logo image filename is relative to the current theme!


**Themes**

You can make your own theme, and specify it's path in the *path*-variable found in the
same section of the config.php-file. The easiset way to do this is to use one of the existing themes
as a starting point, adjusting and changing things to fit your needs. Another option is to simply extend
an existing theme by "inheriting" it and overriding the things you want to change with your own theme.

Place your theme in the site/themes folder and change the theme settings in the config.php. 

* Set the *path* variable to the directory of your theme.

* If you wish to inherit from another theme, set the *parent* variable to the directory of the base theme.

* Set the stylesheet variable to the name of the stylesheet. To inherit from another stylesheet, you use 
the CSS function @import from within your stylesheet. The standard theme uses LESS and an autocompile script 
to compile the CSS stylesheet when needed. That's why it's name is style.php and not style.css. 

* Set the template file to the name of your template file.


**Changing the menu**

Locate the config.php file as described in the previous section, and locate the line that says
"$nx->config['menus'] = array(". This is where you edit the menu items.



Adding content
--------------

You create new content by visiting the URL <nexus_install_url/content. At the bottom of the screen you'll 
find links to creating and viewing your content. You can also edit a previous post by clicking the "edit"-link 
next to the post. You'll notice that your blog is pre-filled with 3 entries when it is installed.

When adding content, you can specify optional filters to use when displaying the content. These filters
currently include *htmlpurify* and *bbcode*. Or just leave this field empty.

**Blogging**

To view your blog, go to <nexus_install_url>/blog. 
To add a blog post, go to <nexus_install_url>/content/create . To make your new content appear as a blog post,
specify *post* as the type.


**Create a page**

Creating a page is done in the same way as creating a new blog entry, except instead of *post* you specify
*page* as the type.