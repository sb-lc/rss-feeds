RSS Feed Test - Simon Beasley
====================

####Instructions
* import the db.sql file to set up db, user and table
* use composer dump-autoload to autoload classes (psr-4)
* setup local server with / as root
* go to index.php (/)


####Improvements
* use session_start() for security
* use tokens for security - $newToken = generateFormToken('form1');
* log hack attempts
* secure sql params - use whitelist
* more namespacing to replace requires
* refresh after delete
* too much logic in view
* performance, get_headers instead of curl
* use all static functions?
* validate xml feed before adding?
* only allow valid xml feeds to be added
* add bulk actions
* add sort data
* needs better blank url handling in edit function
* add Feed::checkFieldExistsById() method

