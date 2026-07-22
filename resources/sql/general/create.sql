CREATE TABLE Users
(

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(64) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    terms BOOLEAN NOT NULL DEFAULT FALSE,
    profile_visibility VARCHAR(150),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL

);

CREATE TABLE ProfileImage
(

    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    profile_image VARCHAR(255) NOT NULL DEFAULT '../uploads/profile/default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_image_user
    FOREIGN KEY (user_id)
    REFERENCES Users(id)
    ON DELETE CASCADE

);

CREATE TABLE UserComments
(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL,
    profile_id INT UNSIGNED NOT NULL,

    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comments_user
    FOREIGN KEY (user_id)
    REFERENCES Users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_comments_profile
    FOREIGN KEY (profile_id)
    REFERENCES Users(id)
    ON DELETE CASCADE

);

CREATE TABLE ProfileDetails
(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    biography TEXT,
    country TEXT,
    city TEXT,
    occupation TEXT,
    website TEXT,
    interests TEXT,
    birthday DATE,
    gender TEXT,
    relationship_status TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_details_user
        FOREIGN KEY (user_id)
        REFERENCES Users(id)
        ON DELETE CASCADE

);

CREATE TABLE ProfileVisibility (

    id INT AUTO_INCREMENT PRIMARY KEY,
    visibility_key VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL

);