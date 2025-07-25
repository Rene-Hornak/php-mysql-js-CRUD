# php-mysql-js-CRUD

Project to build CRUD application for login logout on profil website  
Used stack: **LAMP**

Used SQL in Database:
```sql
    CREATE TABLE users (
    user_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(128),
    email VARCHAR(128),
    password VARCHAR(128),
    PRIMARY KEY(user_id)
    ) ENGINE = InnoDB DEFAULT CHARSET=utf8;

    ALTER TABLE users ADD INDEX(email);
    ALTER TABLE users ADD INDEX(password);
```

```sql
    CREATE TABLE Profile (
    profile_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    first_name TEXT,
    last_name TEXT,
    email TEXT,
    headline TEXT,
    summary TEXT,

    PRIMARY KEY(profile_id),

    CONSTRAINT profile_ibfk_2
            FOREIGN KEY (user_id)
            REFERENCES users (user_id)
            ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```