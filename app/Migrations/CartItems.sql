create table cart_items {
    id int primary key auto_increment,
    cart_id int not null,
    product_id int not null,
    quantity int not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp,
    foreign key (cart_id) references Carts(id),
    foreign key (product_id) references Products(id)
}