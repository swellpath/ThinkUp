CREATE TABLE tu_active_users (
   instance_id INT(11) NOT NULL,
   `date` DATE NOT NULL,
   period ENUM('day', 'week', 'month', 'days_28') NOT NULL DEFAULT 'day',
   count INT UNSIGNED NOT NULL,
   last_updated TIMESTAMP NOT NULL,
   UNIQUE INDEX instance_date (instance_id, date, period),
   INDEX (last_updated)
);
