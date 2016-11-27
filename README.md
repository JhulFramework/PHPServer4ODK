## PHP ODK Aggregate Server (Beta)
ODK aggregate server written in PHP.  Still under development, Using it in serious project is not recomended.
- Usable by ODK collect
- test server http://www.leafpad.in/odk/

### Note :
- I am doing it as side project. I dont know if it useful and worth time. So if you think its worth and you are intrested in using it in future, show your support by giving stars, it will motivate me for further and faster development.

###Requirement

- PHP Version >= 5.5
- MYSQL Database
- Uploadable directory for uploading xforms

### Basic Configuration ( Required )
- use odk.sql to setup database
- set url of your website in 'required/odk/0.1/server/components/app/\_params.php' ['url' => 'yourwebsite url' ]
- configure database by editing 'required/odk/0.1/server/components/database/\_params.php'
- make sure directory 'public_html/uploads/xforms' is writablle for uploading forms

### All Configurations ( Optional )
Component configuartion is located in directories

 - required/odk/0.1/server/components
 - required/odk/0.1/app/config/components  

Change them as your application requirement


###Usage

- Admin Login
	- user: odkadmin
	- pass: odkadmin

- Use empty/any credentials on odk collect
