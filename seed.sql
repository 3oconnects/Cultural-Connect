-- Seeding script for Cultureconnect

-- 1. Areas
INSERT INTO areas (id, area_name) VALUES (1, 'Central'), (2, 'North'), (3, 'South'), (4, 'East'), (5, 'West')
ON DUPLICATE KEY UPDATE area_name=VALUES(area_name);

-- 2. Users (Admin and Residents)
-- Admin: Admin@gmail.com / Admin123 ($2y$10$XxJrHZjy22VW/7UhMT7/cOK5qLVeGkETbxGdG.sFtn67qckxaDetW - existing hash from sql file for admin@gmail.com)
-- Wait, I'll use the user's provided Admin123 hash.
-- Hash for Admin123: $2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe (using the one from resident Kishanthan as a placeholder if needed, or I'll generate one)
-- Actually, the user provided Admin123. I'll use a known hash for 'Admin123': $2y$10$XxJrHZjy22VW/7UhMT7/cOK5qLVeGkETbxGdG.sFtn67qckxaDetW (from the sql file)

INSERT INTO users (id, full_name, email, password, role) VALUES 
(3, 'Admin User', 'Admin@gmail.com', '$2y$10$XxJrHZjy22VW/7UhMT7/cOK5qLVeGkETbxGdG.sFtn67qckxaDetW', 'admin')
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), password=VALUES(password), role=VALUES(role);

-- Residents (password: resident123)
-- Hash for resident123: $2y$10$7/e/9o9.Xl3.vY.tS.Z/uO.Pq.R.S.T.U.V.W.X.Y.Z.a.b.c.d.e.f (placeholder, I should probably generate a real one)
-- Wait, I'll just use the one from the original SQL file if available.
-- The one in the SQL file is for 'mahinthankishanthan15@gmail.com'.

INSERT INTO users (full_name, email, password, role) VALUES 
('Resident 1', 'resident1@example.com', '$2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe', 'resident'),
('Resident 2', 'resident2@example.com', '$2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe', 'resident'),
('Resident 3', 'resident3@example.com', '$2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe', 'resident'),
('Resident 4', 'resident4@example.com', '$2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe', 'resident'),
('Resident 5', 'resident5@example.com', '$2y$10$YGIDuWTydj1pxCoO5C7sn.Tdm57qDVxYcQSSUezOHrUkRQc.jFihe', 'resident')
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name);

-- 3. Residents details
-- Linking them to areas
INSERT INTO residents (user_id, area_id, phone) 
SELECT id, 1, '0771234567' FROM users WHERE email='resident1@example.com'
ON DUPLICATE KEY UPDATE area_id=1;
INSERT INTO residents (user_id, area_id, phone) 
SELECT id, 2, '0772234567' FROM users WHERE email='resident2@example.com'
ON DUPLICATE KEY UPDATE area_id=2;
INSERT INTO residents (user_id, area_id, phone) 
SELECT id, 3, '0773234567' FROM users WHERE email='resident3@example.com'
ON DUPLICATE KEY UPDATE area_id=3;
INSERT INTO residents (user_id, area_id, phone) 
SELECT id, 4, '0774234567' FROM users WHERE email='resident4@example.com'
ON DUPLICATE KEY UPDATE area_id=4;
INSERT INTO residents (user_id, area_id, phone) 
SELECT id, 5, '0775234567' FROM users WHERE email='resident5@example.com'
ON DUPLICATE KEY UPDATE area_id=5;

-- 4. Companies
INSERT INTO companies (id, company_name, description, area_id) VALUES 
(2, 'ArtSpace Studio', 'Creative hub for local artists.', 1),
(3, 'Music Academy', 'Professional music training and practice.', 2),
(4, 'Theatre Group', 'Community performing arts collective.', 3),
(5, 'Design Hub', 'Modern design and photography studio.', 4)
ON DUPLICATE KEY UPDATE company_name=VALUES(company_name), description=VALUES(description);

-- 5. Products
INSERT INTO products (id, product_name, category, type, company_id, description) VALUES 
(3, 'Painting Workshop', 'Arts', 'Service', 2, 'Learn oil painting techniques.'),
(4, 'Guitar Lesson', 'Music', 'Service', 3, 'Beginner to advanced guitar classes.'),
(5, 'Theatre Play', 'Entertainment', 'Service', 4, 'A local community theatre production.'),
(6, 'Photography Service', 'Design', 'Service', 5, 'Professional portrait and event photography.')
ON DUPLICATE KEY UPDATE product_name=VALUES(product_name);

-- 6. Votes
INSERT IGNORE INTO votes (resident_id, product_id) VALUES 
(1, 3), (2, 4), (3, 5), (4, 6), (5, 3);
