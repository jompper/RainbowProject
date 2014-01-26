CREATE TABLE roles (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	role_id INT NOT NULL REFERENCES roles(id),
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	full_name VARCHAR(255) NOT NULL
);

CREATE TABLE priorities (
	id SERIAL PRIMARY KEY,
	priority INT NOT NULL,
	name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE statuses (
	id SERIAL PRIMARY KEY,
	name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE customers (
	id SERIAL PRIMARY KEY,
	priority_id INT REFERENCES priorities(id),
	name VARCHAR(255) NOT NULL,
	business_id VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE projects (
	id SERIAL PRIMARY KEY,
	customer_id INT NOT NULL REFERENCES customers(id),
	priority_id INT NOT NULL REFERENCES priorities(id),
	due_date TIMESTAMP,
	name VARCHAR(50) NOT NULL,
	description TEXT,
	UNIQUE(customer_id, name)
);


CREATE TABLE tasks (
	id SERIAL PRIMARY KEY,
	project_id INT NOT NULL REFERENCES projects(id),
	priority_id INT NOT NULL REFERENCES priorities(id),	
	status_id INT NOT NULL REFERENCES statuses(id),
	due_date TIMESTAMP NOT NULL,
	hour_estimate INT NOT NULL,
	name VARCHAR(50) NOT NULL,
	description TEXT
);

CREATE TABLE project_comments (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id),
	project_id INT NOT NULL REFERENCES projects(id),
	post_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
	title VARCHAR(50) NOT NULL,
	comment TEXT NOT NULL
);

CREATE TABLE task_comments (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id),
	task_id INT NOT NULL REFERENCES tasks(id),
	post_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
	title VARCHAR(50) NOT NULL,
	comment TEXT NOT NULL
);

CREATE TABLE user_tasks (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id),
	task_id INT NOT NULL REFERENCES tasks(id),
	UNIQUE(user_id, task_id)
);
