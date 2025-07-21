CREATE TABLE IF NOT EXISTS refresh_token (
  token        TEXT    PRIMARY KEY,
  user_uuid    TEXT    NOT NULL,
  is_expired   INTEGER NOT NULL DEFAULT 0,
  expire_at    TEXT    NULL
);

CREATE INDEX IF NOT EXISTS idx_refresh_token_user_uuid
  ON refresh_token(user_uuid);