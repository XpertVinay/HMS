-- Admin table updates
ALTER TABLE admin ADD COLUMN mobile_number VARCHAR(20) DEFAULT NULL;
ALTER TABLE admin ADD COLUMN rwa_election_copy VARCHAR(255) DEFAULT NULL;
ALTER TABLE admin ADD COLUMN social_registration_number VARCHAR(100) DEFAULT NULL;
ALTER TABLE admin ADD COLUMN is_id_verified BOOLEAN DEFAULT FALSE;

-- Member table updates
ALTER TABLE member ADD COLUMN share_certificate VARCHAR(255) DEFAULT NULL;
ALTER TABLE member ADD COLUMN is_deed_verified_staff BOOLEAN DEFAULT FALSE;
ALTER TABLE member ADD COLUMN is_deed_verified_admin BOOLEAN DEFAULT FALSE;

-- Staff table updates
ALTER TABLE staff ADD COLUMN mobile_number VARCHAR(20) DEFAULT NULL;
ALTER TABLE staff ADD COLUMN employment_contract VARCHAR(255) DEFAULT NULL;
ALTER TABLE staff ADD COLUMN is_id_verified BOOLEAN DEFAULT FALSE;

-- Resident table
CREATE TABLE IF NOT EXISTS resident (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    mobile_number VARCHAR(20) DEFAULT NULL,
    organization_id INT DEFAULT NULL,
    owner_noc VARCHAR(255) DEFAULT NULL,
    is_rent_agreement_verified_staff BOOLEAN DEFAULT FALSE,
    is_rent_agreement_verified_admin BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vendor table
CREATE TABLE IF NOT EXISTS vendor (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    business_name VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    business_registration VARCHAR(255) DEFAULT NULL,
    organization_id INT DEFAULT NULL,
    bank_account_details TEXT DEFAULT NULL,
    is_gst_verified_staff BOOLEAN DEFAULT FALSE,
    is_gst_verified_admin BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Property table
CREATE TABLE IF NOT EXISTS property (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    address VARCHAR(255) NOT NULL UNIQUE,
    type VARCHAR(50) DEFAULT 'Flat',
    owner_id INT DEFAULT NULL,
    organization_id INT DEFAULT NULL,
    resident_id INT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES member(id) ON DELETE SET NULL,
    FOREIGN KEY (resident_id) REFERENCES resident(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vendor Invoice table
CREATE TABLE IF NOT EXISTS vendor_invoice (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    vendor_id INT NOT NULL,
    invoice_file VARCHAR(255) NOT NULL,
    amount DOUBLE NOT NULL,
    organization_id INT DEFAULT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendor(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
