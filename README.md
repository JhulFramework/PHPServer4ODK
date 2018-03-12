
It was my hobby project so i may not be able to give it much time.
**Forms are not validated so using it on serious project is not recomended**


## PHP ODK Aggregate Server
- Only single user supported
- It does not supports forms with file(s) (e.g. images)

### Requirement

- PHP Version >= 5.6
- MYSQL Database
- Uploadable directory for uploading xml forms

### Basic Configuration ( Required )
- use odk.sql to setup database
- set url of your website in 'required/\_config.php'
- make sure directory 'public_html/uploads/xforms' is writable for uploading forms

### All Configurations ( Optional )
Component configuartion is located in directories
 - required/odk/0.1/\_components

Change them as your application requirement

### Usage

- Admin Login
	- user: odkadmin
	- pass: odkadmin

- Use any credentials on odk collect
