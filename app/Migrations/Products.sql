create table products {
    id int primary key auto_increment,
    name varchar(255) not null,
    price int not null,
    code varchar(5) unique not null,
    catalogue varchar(255) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
}