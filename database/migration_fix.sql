USE scholarhub;

-- Safe migration for an older ScholarHub scholarships table.
ALTER TABLE scholarships ADD COLUMN IF NOT EXISTS study_level VARCHAR(150) NULL;
ALTER TABLE scholarships ADD COLUMN IF NOT EXISTS fields TEXT NULL;
ALTER TABLE scholarships ADD COLUMN IF NOT EXISTS funding_type VARCHAR(100) NULL;

-- These are intentionally blank when the old database did not contain the information.
-- Fill them later from the official scholarship source or through Admin > Scholarships.
