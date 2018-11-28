CREATE TABLE User (
    username varchar(20) NOT NULL,
    password varchar(20) NOT NULL,
    emailAd varchar(80) NOT NULL,
    phoneNo Int(12),
    profilePic varchar(255),
	Bdate Date,
	Fname varchar(20),
	Lname varchar(20),
	postalCode Int(10) NOT NULL,
	city varchar(20) NOT NULL,
	country varchar(20) NOT NULL,
	adLine1 varchar(255) NOT NULL,
	adLine2 varchar(255),
	SPR varchar(20) NOT NULL,
	CONSTRAINT user_username_pk PRIMARY KEY(username)
);

CREATE TABLE Seller (
    username varchar(20),
    balance DECIMAL(19,2),
    CONSTRAINT seller_username_pk PRIMARY KEY(username),
    CONSTRAINT seller_username_fk FOREIGN KEY(username) REFERENCES User(username)
);

CREATE TABLE Buyer (
	username varchar(20),
	payment_type varchar(20),
	CCNo Int(16),
	secuirtyNo Int(4),
	CONSTRAINT buyer_username_pk PRIMARY KEY(username),
	CONSTRAINT buyer_username_fk FOREIGN KEY(username) REFERENCES User(username)
);

CREATE TABLE Category (
	name varchar(40),
	CONSTRAINT category_name_pk PRIMARY KEY(name)
);

CREATE TABLE Store (
	name varchar(40),
	username varchar(20),
	CONSTRAINT store_name_pk PRIMARY KEY(name),
	CONSTRAINT store_username_fk FOREIGN KEY(username) REFERENCES Seller(username)
);

CREATE TABLE Store_Category (
	Sname varchar(40),
	CatName varchar(20),
	CONSTRAINT store_category_sname_fk FOREIGN KEY(Sname) REFERENCES Store(name),
	CONSTRAINT store_category_catname_fk FOREIGN KEY(CatName) REFERENCES Category(name),
	CONSTRAINT store_category_pk PRIMARY KEY(Sname, CatName)
);

CREATE TABLE Product (
	PId Int(9) AUTO_INCREMENT,
	Pname varchar(20),
	price DECIMAL(19,2),
	status varchar(20),
	picture varchar(255),
	description varchar(255),
	CatName varchar(20),
	Sname varchar(40),
	CONSTRAINT product_pid_pk PRIMARY KEY(PId),
	CONSTRAINT product_catname_fk FOREIGN KEY(CatName) REFERENCES Category(name),
	CONSTRAINT product_sname_fk FOREIGN KEY(Sname) REFERENCES Store(name)
);

CREATE TABLE Product_Spec (
	PId Int(9),
	name varchar(20),
	value varchar(60),
	CONSTRAINT product_spec_pid_fk FOREIGN KEY(PId) REFERENCES Product(PId),
	CONSTRAINT pk_product_spec PRIMARY KEY (PId,name)
);

CREATE TABLE Cart (
    username varchar(20),
	PId Int(9),
	CONSTRAINT cart_username_fk FOREIGN KEY(username) REFERENCES User(username),
	CONSTRAINT cart_pid_fk FOREIGN KEY(PId) REFERENCES Product(PId),
	CONSTRAINT pk_cart PRIMARY KEY (username,PId)
);

CREATE TABLE Transaction (
	ReferenceNo Int(9) AUTO_INCREMENT,
    username varchar(20),
	PId Int(9),
	rating DECIMAL(2, 1),
	review varchar(255),
	sellingDate Date,
	CONSTRAINT transaction_referenceno_pk PRIMARY KEY(ReferenceNo),
	CONSTRAINT transaction_username_fk FOREIGN KEY(username) REFERENCES Buyer(username),
	CONSTRAINT transaction_pid_fk FOREIGN KEY(PId) REFERENCES Product(PId)
);
