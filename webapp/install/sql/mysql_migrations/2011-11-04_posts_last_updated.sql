ALTER TABLE tu_posts ADD last_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last time this post was updated (or first inserted)';
UPDATE tu_posts SET last_updated = NOW();
