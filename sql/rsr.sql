drop schema rsr;
create schema rsr
default character set utf8;

use rsr;
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(100) UNIQUE,
    password VARCHAR(512) NOT NULL,
    birth_date DATE,
    updated_at VARCHAR(4000),
    created_at VARCHAR(4000),
    profile_picture BLOB,
    remember_token VARCHAR(100),
    PRIMARY KEY (id)
);

CREATE TABLE user_sessions (
    user_session_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    session VARCHAR(4000),
    PRIMARY KEY (user_session_id)
);

CREATE TABLE points (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    point INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);


CREATE TABLE rating_types (
    id INT NOT NULL AUTO_INCREMENT,
    rating_name VARCHAR(50) NOT NULL,
    lower_limit INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE friendships (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id)
);

CREATE TABLE friend_requests (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id)
);


CREATE TABLE room_roles (
    id INT NOT NULL AUTO_INCREMENT,
    room_role_type VARCHAR(50),
    PRIMARY KEY (id)
);


CREATE TABLE rooms (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE room_requests (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    room_id INT NOT NULL,
    room_role_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (room_role_id)
        REFERENCES room_roles (id)
);

CREATE TABLE room_members (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE message_types (
    id INT NOT NULL AUTO_INCREMENT,
    message_type VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE room_messages (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    message VARCHAR(4000),
    message_type_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (message_type_id)
        REFERENCES message_types (id)
);

CREATE TABLE room_answers (
    id INT NOT NULL AUTO_INCREMENT,
    room_message_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (id),
    FOREIGN KEY (room_message_id)
        REFERENCES room_messages (id)
);


CREATE TABLE question_levels (
    id INT NOT NULL AUTO_INCREMENT,
    question_level VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE questions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    question_content VARCHAR(4000),
    question_level_id INT NOT NULL,
    is_public BOOLEAN NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (question_level_id)
        REFERENCES question_levels (id)
);

CREATE TABLE answers (
    id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id)
);


CREATE TABLE answered_questions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE tournament_statuses (
    id INT NOT NULL AUTO_INCREMENT,
    status VARCHAR(50),
    PRIMARY KEY (id)
);


CREATE TABLE tournaments (
    id INT NOT NULL AUTO_INCREMENT,
    tournament_name VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    min_rating_type_id INT NOT NULL,
    max_rating_type_id INT NOT NULL,
    tournament_status_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (min_rating_type_id)
        REFERENCES rating_types (id),
    FOREIGN KEY (max_rating_type_id)
        REFERENCES rating_types (id),
    FOREIGN KEY (tournament_status_id)
        REFERENCES tournament_statuses (id)
);

CREATE TABLE tournament_questions (
    id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (id)
);


CREATE TABLE tournament_users (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (id)
);

INSERT INTO `rsr`.`users` (`name`, `email`, `username`, `password`) VALUES ('tamuna', 'tgeld15@freeuni.edu.ge', 'tgeld15', '12345678');
INSERT INTO `rsr`.`users` (`name`, `email`, `username`, `password`) VALUES ('levan','lkara15@freeuni.edu.ge','lkara15', '12345678');

INSERT INTO `rsr`.`friendships` (`user_one_id`, `user_two_id`) VALUES ('1', '2');
INSERT INTO `rsr`.`friendships` (`user_one_id`, `user_two_id`) VALUES ('2', '1');

INSERT INTO `rsr`.`question_levels` (`question_level`) VALUES ('easy');
INSERT INTO `rsr`.`question_levels` (`question_level`) VALUES ('medium');
INSERT INTO `rsr`.`question_levels` (`question_level`) VALUES ('hard');

INSERT INTO `rsr`.`questions` (`user_id`, `question_content`, `question_level_id`, `is_public`) VALUES ('1', 'tamunas question', '1', '1');
INSERT INTO `rsr`.`questions` (`user_id`, `question_content`, `question_level_id`, `is_public`) VALUES ('2', 'levanis question', '2', '1');

