Q->Answer
================

dbwebb.se KMOM710 WIP

Installation
------------------
Step 1 Clone it

    git clone https://github.com/nuvalis/GMAQ.git

Step 2 Use Composer to install the required packages.

Step 3 Make sure the webroot/.htaccess file is configured correctly.

Step 4 Check that app/db folder is existing and is writable. This is where the standard Sqlite file will be generated

Step 5 Visit {yoururl}/webroot/install and {yoururl}/webroot/setup for the tables and db to be generated.

Step 6 Thats it! Start posting and testing the code!

TODO
==========

- [x] Add Ajax support for VoteController
- [x] Build Up Comments, Answers and Questsions Section
- [ ] Implement Groups
	- [ ] Permissions
	- [ ] Better Auth
- [x] Implement Tagging
- [ ] Clean Up Code

Notes
=====================
Remember to change newActions() cat_id

License
==========
The MIT License (MIT)

Copyright (c) 2014 Emil Nordqvist

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.


