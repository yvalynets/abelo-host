create table categories
(
    id          int unsigned auto_increment primary key,
    name        varchar(255) not null,
    description text
) engine = InnoDB
  default charset = utf8mb4;

create table articles
(
    id          int unsigned auto_increment primary key,
    title       varchar(255) not null,
    description text,
    text        mediumtext   not null,
    image       varchar(255),
    views       int unsigned not null default 0,
    created_at  datetime     not null default current_timestamp,
    index idx_created_at (created_at),
    index idx_views (views)
) engine = InnoDB
  default charset = utf8mb4;

create table article_category
(
    article_id  int unsigned not null,
    category_id int unsigned not null,
    primary key (article_id, category_id),
    foreign key (article_id) references articles (id) on delete cascade,
    foreign key (category_id) references categories (id) on delete cascade
) engine = InnoDB
  default charset = utf8mb4;
