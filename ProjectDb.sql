#this table is to store all companies which buy todo app
CREATE TABLE IF NOT EXISTS csci4145project.Customer(
#company code is an unique id for each company
CompanyCode VARCHAR(255) NOT NULL,
CompanyName VARCHAR(255),
#admin user name is to show that this user in the company is an admin user
AdminUserName VARCHAR(255) NOT NULL
);

#company table is to store all employees' information 
CREATE TABLE IF NOT EXISTS csci4145project.Company(
CompanyCode VARCHAR(255) NOT NULL,
UserName VARCHAR(255) NOT NULL,
UserPassword VARCHAR(255) NOT NULL
);

#store all information for each employee
CREATE TABLE IF NOT EXISTS csci4145project.Employee(
LastName VARCHAR(255),
FirstName VARCHAR(255),
UserName VARCHAR(255) NOT NULL,
UserPassword VARCHAR(255) NOT NULL,
Email VARCHAR(255)
);

#store all todo tasks
CREATE TABLE IF NOT EXISTS csci4145project.Task(
TaskID VARCHAR(255) not null,
#the todo task is assigned from fromuser(user name)
FromUser Varchar(255) NOT NULL,
#the task is assgined to touser(user name)
ToUser Varchar(255) NOT NULL,
Title VARCHAR(255) NOT NULL,
Detail VARCHAR(255),
CreateTime datetime,
Deadline datetime,
#STORE THE PATH OF A PICTURE
PicturePath LONGBLOB
);









INSERT INTO csci4145project.Customer VALUES('CD1' ,'NM1' ,'AD1');
INSERT INTO csci4145project.Customer VALUES('CD2' ,'NM2' ,'AD2');
INSERT INTO csci4145project.Customer VALUES('CD3' ,'NM3' ,'AD3');
INSERT INTO csci4145project.Customer VALUES('CD4' ,'NM4' ,'AD4');

INSERT INTO csci4145project.Company VALUES('CD1' ,'UN1' ,'PWD1');
INSERT INTO csci4145project.Company VALUES('CD2' ,'UN2' ,'PWD2');
INSERT INTO csci4145project.Company VALUES('CD3' ,'UN3' ,'PWD3');
INSERT INTO csci4145project.Company VALUES('CD4' ,'UN4' ,'PWD4');
INSERT INTO csci4145project.Company VALUES('CD1' ,'UN5' ,'PWD5');

INSERT INTO csci4145project.Employee VALUES('LN1' ,'FN1' ,'UN1' ,'PWD1' ,'EM1');
INSERT INTO csci4145project.Employee VALUES('LN2' ,'FN2' ,'UN2' ,'PWD2' ,'EM2');
INSERT INTO csci4145project.Employee VALUES('LN3' ,'FN3' ,'UN3' ,'PWD3' ,'EM3');
INSERT INTO csci4145project.Employee VALUES('LN4' ,'FN1' ,'UN4' ,'PWD4' ,'EM4');





COMMIT;
