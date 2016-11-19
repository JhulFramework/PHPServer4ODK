2016-Nov-05

use flag to either to check if class_exixsts during loading configuration, and cache it,

it is no caching currently , so it might be overhead to check for class exists

- autoload error xhelper from component directory

=============================================================
- 2016-Nov-04
MOve BFD insid form component
----------------------------------------
use simple routing like "module/handler" //DONE before 2016-july-02

improve view file mapping, file name should be independent of view name //Done On July-2016

auto generate models, handlers , controllers

build css compiler

build app generator

default module should be main


fieldDefinitions
{
	return
	[
		'name' => 'string::L=3-9:R=true'
	];
}
//DONE 2016-july


- way to insert user entity class in client, controling app user

- Ability to auto configure app base url


=================== 2016-july-02 ============================
- Database Writable trait
//Done on 2016-July


- instead of set and get use read and write
//DOne on 2016-July

-------------------------------------------------------------

===================2016-Jul7-05============================

- Auto Create table if not exists


====2016-07-07==
fix breadcrumb order

make breadcrumbS small and custom seperator


TODO === 2016august02
special page for showing detailed exceptions with possible solution


2016 august 04 =========================================================================================================
application needs different cook adapter like HTML, JSON
current Page is HTML type should belong to inside HTML, independent of Application

implement  $this->HTML()->render(),


------------------------------------------------------------------------------------------------------------------------

2016-august-06 =========================================================================================================

datababse entity class sholud be acccess using  class::I( constructoer_params )->db()->byIK( $ik )->make();

when entity load table it should itself not class so ttaht table context should be customized according to entity

setContext() can be used to overrid entity

 verify reources exists during mapping and then cache it
------------------------------------------------------------------------------------------------------------------------

2016-august-23 =========================================================================================================

abstract database writing methods in a class and use something like $entity->writer()->write(), to improve permormance
because most of the time datamodels are used to read
since entities are mostly used for reading , all modification methods must be abastracted in sepreate model

2016-Sep-29 ===========================================================================================================
//CANCELLED - IT WILL COMPLICATE STUFF
framework must not be singleton, to facilitate running of multiple application with totally f=differentc configurations
frameke should be like app loader and  app runner, it hsouldbe be able to load application without running it

something like

- make app from app src
- run app optiontional

app1 = makeapp(app1)
app2 = makeapp(app2)


2016-Oct-18=============================================================================================================
//CANCELLED - USING DIFFERENT DESIGN
Move Client request under Applictaion

$app->client->request

$app->client->consumerType //webpage or json
