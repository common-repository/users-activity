=== Users Activity - convert visitors to users ===
Contributors: lobov
Donate link: https://wow-estore.com/
Tags: user, users, login, logout, add post, user activity, lostpassword, confirmation of mail, email validation 
Requires at least: 4.2
Tested up to: 5.2
Requires PHP: 5.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily create login, registration and lost password forms. Displaying User Activity 

== Description ==
Plugin Users Activity is designed for more successful conversion of site visitors to regular users. With the help of the plugin it is possible to register new users on the site with confirmation of their email, and also it’s convenient to create in the navigation menu links to the pages of the account, registration, sign-in and other user pages. It is also possible to monitor and display user activity on the page using a shortcode.


= Main features =
* User registration with confirmation by e-mail;
* Adding the user to Email Marketing Services after registration via plugin  [Email Marketing Services Integration](https://wordpress.org/plugins/email-marketing-services-integration);
* Shortcodes for displaying registration forms, logging in, password recovery, profile editing, adding an entry, displaying all comments and user records, displaying current user activity and displaying users activity;
* Configuring redirects after logging in, logging out, and registration;
* Adding navigation points to the menu for registered and unregistered users;
* Displaying the user name in the menu when it is registered;
* Export users to CSV;
* Sending a welcome message by mail after registration and email confirmation.

= Shortcodes =

* [ua_register] – display registration form on the page
* [ua_login] – display logging in form on the page
* [ua_lost_password] – display password recovery form
* [ua_profile] – user profile editing form
* [ua_comments] – display all the comments left by user on the site 
* [ua_posts] – display all the user published records on the site
* [ua_add_posts] – entry adding form
* [ua_user_activity] – display current registered user activity
* [ua_users_activities] – display all the registered users activity. 
* [ua_restrict] - hides the content that is inside the structure [ua_restrict] [/ua_restrict] for the unregistered users.


= Example for shortcodes = 

[ua_users_activities type=”post”  number=”10”] – displays 10 last records that users added 

Possible to use additional options to display a list of user activity [ua_users_activities]:

* type – user activity type, can be post, comment, register, all activity types are displayed by default.
* number – displays the specified number of records, 30 records are output by default

[ua_restrict] Some text for registered users [/ua_restrict]. If the user is not registered the following message will be displayed: You must be logged in to view this content


== Installation ==
* Installation option 1: Find and install this plugin in the `Plugins` -> `Add new` section of your `wp-admin`
* Installation option 2: Download the zip file, then upload the plugin via the wp-admin in the `Plugins` -> `Add new` section. Or unzip the archive and upload the folder to the plugins directory `/wp-content/plugins/` via ftp
* Press `Activate` when you have installed the plugin via dashboard or press `Activate` in the in the `Plugins` list 
* Go to `Users Activity` section that will appear in your main menu on the left
* Setup plugin

== Frequently Asked Questions ==
= Users export  =

Plugin Users Activity allows to export user data such as 'ID','Username','First Name', 'Last Name', 'Email', 'Registration' to CSV file for further use elsewhere.

It is possible to export all users data pressing the button “Export all users in CSV” 
Also it is available to export only selected users data.


= Activity export  =

To display the activity of current users there is the possibility to export activity data with the help of function ‘Import Activity’.

== Screenshots ==
1. Users
2. General settings
3. Emails settings
4. Extensions settings
5. Menu settings


== Changelog ==

= 1.0 = 
* Initial release