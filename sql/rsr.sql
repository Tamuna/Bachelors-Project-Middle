create schema rsr;
use rsr;
CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(512) NOT NULL,
    birth_date DATE,
    profile_picture BLOB,
    PRIMARY KEY (user_id)
);

create table user_sessions(
	user_session_id int not null auto_increment,
    user_id int not null,
    session varchar(4000),
    
    primary key(user_session_id)
);

CREATE TABLE points (
    point_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    point INT NOT NULL,
    PRIMARY KEY (point_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id)
);


CREATE TABLE rating_types (
    rating_type_id INT NOT NULL AUTO_INCREMENT,
    rating_name ENUM('BEGINNER', 'MASTER') NOT NULL,
    lower_limit INT NOT NULL,
    PRIMARY KEY (rating_type_id)
);


CREATE TABLE contact_types (
    contact_type_id INT NOT NULL AUTO_INCREMENT,
    contact_type_name ENUM('MAIL', 'PHONE') NOT NULL,
    PRIMARY KEY (contact_type_id)
);

CREATE TABLE contacts (
    contact_id INT NOT NULL AUTO_INCREMENT,
    contact_type_id INT NOT NULL,
    user_id INT NOT NULL,
    contact VARCHAR(100),
    PRIMARY KEY (contact_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id),
    FOREIGN KEY (contact_type_id)
        REFERENCES contact_types (contact_type_id)
);

CREATE TABLE friendships (
    friendship_id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    PRIMARY KEY (friendship_id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (user_id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (user_id)
);

CREATE TABLE friend_requsts (
    friend_requst_id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    PRIMARY KEY (friend_requst_id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (user_id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (user_id)
);

CREATE TABLE room_roles (
    room_role_id INT NOT NULL AUTO_INCREMENT,
    room_role_type ENUM('CAPTAIN', 'PRESENTER', 'PLAYER'),
    PRIMARY KEY (room_role_id)
);


CREATE TABLE rooms (
    room_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100),
    PRIMARY KEY (room_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id)
);

CREATE TABLE room_requests (
    room_request_id INT NOT NULL AUTO_INCREMENT,
    user_one_id INT NOT NULL,
    user_two_id INT NOT NULL,
    room_id INT NOT NULL,
    room_role_id INT NOT NULL,
    PRIMARY KEY (room_request_id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (user_id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (user_id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (room_id),
    FOREIGN KEY (room_role_id)
        REFERENCES room_roles (room_role_id)
);

CREATE TABLE room_members (
    room_member_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    PRIMARY KEY (room_member_id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (room_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id)
);

CREATE TABLE message_types (
    message_type_id INT NOT NULL AUTO_INCREMENT,
    message_type ENUM('MESSAGE', 'QUESTION') NOT NULL,
    PRIMARY KEY (message_type_id)
);

CREATE TABLE room_messages (
    room_message_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    message VARCHAR(4000),
    message_type_id INT NOT NULL,
    PRIMARY KEY (room_message_id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (room_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id),
    FOREIGN KEY (message_type_id)
        REFERENCES message_types (message_type_id)
);

CREATE TABLE room_answers (
    room_answer_id INT NOT NULL AUTO_INCREMENT,
    room_message_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (room_answer_id),
    FOREIGN KEY (room_message_id)
        REFERENCES room_messages (room_message_id)
);


CREATE TABLE question_levels (
    question_level_id INT NOT NULL AUTO_INCREMENT,
    question_level ENUM('EASY', 'MEDIUM', 'HARD'),
    PRIMARY KEY (question_level_id)
);

CREATE TABLE questions (
    question_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    question_content VARCHAR(4000),
    question_level_id INT NOT NULL,
    is_public BOOLEAN NOT NULL,
    PRIMARY KEY (question_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id),
    FOREIGN KEY (question_level_id)
        REFERENCES question_levels (question_level_id)
);

CREATE TABLE answers (
    answer_id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (answer_id),
    FOREIGN KEY (question_id)
        REFERENCES questions (question_id)
);


CREATE TABLE answered_questions (
    answered_question_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    PRIMARY KEY (answered_question_id),
    FOREIGN KEY (question_id)
        REFERENCES questions (question_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id)
);

CREATE TABLE tournament_status (
    tournament_status_id INT NOT NULL AUTO_INCREMENT,
    status ENUM('PRESENT', 'PAST', 'FUTURE'),
    PRIMARY KEY (tournament_status_id)
);


CREATE TABLE tournaments (
    tournament_id INT NOT NULL AUTO_INCREMENT,
    tournament_name VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    min_rating_type_id INT NOT NULL,
    max_rating_type_id INT NOT NULL,
    tournament_status_id INT NOT NULL,
    PRIMARY KEY (tournament_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id),
    FOREIGN KEY (min_rating_type_id)
        REFERENCES rating_types (rating_type_id),
    FOREIGN KEY (max_rating_type_id)
        REFERENCES rating_types (rating_type_id),
    FOREIGN KEY (tournament_status_id)
        REFERENCES tournament_status (tournament_status_id)
);

CREATE TABLE tournament_questions (
    tournament_question_id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (tournament_question_id),
    FOREIGN KEY (question_id)
        REFERENCES questions (question_id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (tournament_id)
);


CREATE TABLE tournament_users (
    tournament_question_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (tournament_question_id),
    FOREIGN KEY (user_id)
        REFERENCES users (user_id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (tournament_id)
);



