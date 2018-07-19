#this table is to store all companies which buy todo app
CREATE TABLE IF NOT EXISTS csci4145project.Customer(
#company code is an unique id for each company
CompanyCode VARCHAR(255) PRIMARY KEY NOT NULL,
CompanyName VARCHAR(255),
#admin user name is to show that this user in the company is an admin user
AdminUserName VARCHAR(255) NOT NULL
);

#company table is to store all employees' information 
CREATE TABLE IF NOT EXISTS csci4145project.Company(
CompanyCode VARCHAR(255) NOT NULL,
CompanyName VARCHAR(255) NOT NULL,
UserName VARCHAR(255) PRIMARY KEY NOT NULL,
UserPassword VARCHAR(255) NOT NULL,
foreign key (CompanyCode) references Customer(CompanyCode)
);

#store all information for each employee
CREATE TABLE IF NOT EXISTS csci4145project.Employee(
LastName VARCHAR(255),
FirstName VARCHAR(255),
UserName VARCHAR(255) NOT NULL,
UserPassword VARCHAR(255) NOT NULL,
Email VARCHAR(255),
foreign key (UserName) references Company(UserName)
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
PicturePath VARCHAR(255),
foreign key (FromUser) references Employee(Username),
foreign key (ToUser) references Employee(Username)
);


COMMIT;