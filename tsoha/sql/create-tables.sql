CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	full_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	admin BOOLEAN NOT NULL DEFAULT false
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
	business_id VARCHAR(20) NOT NULL UNIQUE,
	email VARCHAR(255),
	phone VARCHAR(50)
);

CREATE TABLE projects (
	id SERIAL PRIMARY KEY,
	customer_id INT NOT NULL REFERENCES customers(id) ON DELETE CASCADE,
	priority_id INT NOT NULL REFERENCES priorities(id),
	status_id INT NOT NULL REFERENCES statuses(id),
	due_date TIMESTAMP NOT NULL,
	name VARCHAR(50) NOT NULL,
	description TEXT,
	UNIQUE(customer_id, name)
);


CREATE TABLE tasks (
	id SERIAL PRIMARY KEY,
	project_id INT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
	priority_id INT NOT NULL REFERENCES priorities(id),	
	status_id INT NOT NULL REFERENCES statuses(id),
	due_date TIMESTAMP NOT NULL,
	hour_estimate INT NOT NULL,
	name VARCHAR(50) NOT NULL,
	description TEXT
);

CREATE TABLE project_comments (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	project_id INT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
	post_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
	comment TEXT NOT NULL
);

CREATE TABLE task_comments (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	task_id INT NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	post_date TIMESTAMP NOT NULL DEFAULT current_timestamp,
	comment TEXT NOT NULL
);

CREATE TABLE user_tasks (
	user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	task_id INT NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	PRIMARY KEY(user_id, task_id)
);

CREATE TABLE user_task_hours (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	task_id INT NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	start_time TIMESTAMP NOT NULL,
	end_time TIMESTAMP NOT NULL DEFAULT current_timestamp,
	description TEXT NOT NULL,
	UNIQUE(user_id, task_id, start_time, description)
);
