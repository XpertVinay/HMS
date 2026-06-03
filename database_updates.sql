-- Database updates for new public listing pages

CREATE TABLE IF NOT EXISTS `donors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `donation_date` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some dummy data for testing
INSERT INTO `donors` (`name`, `email`, `amount`, `donation_date`) VALUES
('John Doe', 'john@example.com', 500.00, '2023-01-15'),
('Jane Smith', 'jane@example.com', 1250.00, '2023-02-20'),
('Michael Johnson', 'michael@example.com', 300.00, '2023-03-05');

INSERT INTO `sponsors` (`name`, `logo_url`, `description`, `website_url`) VALUES
('Tech Corp', 'https://via.placeholder.com/150x80?text=Tech+Corp', 'Leading technology solutions provider.', 'https://example.com'),
('Green Energy Solutions', 'https://via.placeholder.com/150x80?text=Green+Energy', 'Sustainable and renewable energy for a better tomorrow.', 'https://example.com');

INSERT INTO `events` (`title`, `description`, `event_date`, `event_time`) VALUES
('Annual General Meeting', 'Discussing society matters and upcoming projects.', '2023-12-10', '10:00:00'),
('New Year Celebration', 'Join us for a grand New Year party with music and food.', '2023-12-31', '20:00:00'),
('Community Clean-up Drive', 'Volunteers needed for the monthly clean-up drive.', '2023-11-05', '08:00:00');

INSERT INTO `gallery` (`title`, `image_url`, `description`) VALUES
('Holi Celebration 2022', 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?auto=format&fit=crop&q=80&w=800', 'Residents enjoying the festival of colors.'),
('Society Park Inauguration', 'https://images.unsplash.com/photo-1519331379826-f10be5486c6f?auto=format&fit=crop&q=80&w=800', 'The new park inaugurated by the committee.'),
('Diwali Decoration', 'https://images.unsplash.com/photo-1541781287661-755d4924a682?auto=format&fit=crop&q=80&w=800', 'Beautifully decorated entrance for Diwali.');
