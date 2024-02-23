create carts {
    id int primary key auto_increment,
    user_id int not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
}