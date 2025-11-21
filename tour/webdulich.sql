-- Database: webdulich
-- Created for GoTravel tour travel website

CREATE DATABASE IF NOT EXISTS webdulich DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webdulich;

-- Users table for storing user registration information
CREATE TABLE tblusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    EmailId VARCHAR(100) NOT NULL UNIQUE,
    FullName VARCHAR(255) NOT NULL,
    MobileNumber VARCHAR(15),
    Password VARCHAR(255) NOT NULL,
    RegDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdationDate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tour packages table for storing available tour packages
CREATE TABLE tbltourpackages (
    PackageId INT AUTO_INCREMENT PRIMARY KEY,
    PackageName VARCHAR(255) NOT NULL,
    PackageType VARCHAR(150) NOT NULL,
    PackageLocation VARCHAR(150) NOT NULL,
    PackagePrice DECIMAL(10, 2) NOT NULL,
    PackageFetures TEXT,
    PackageDetails LONGTEXT,
    PackageImage VARCHAR(255),
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdationDate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Booking table for storing user tour bookings
CREATE TABLE tblbooking (
    BookingId INT AUTO_INCREMENT PRIMARY KEY,
    PackageId INT NOT NULL,
    UserEmail VARCHAR(100) NOT NULL,
    FromDate DATE NOT NULL,
    ToDate DATE NOT NULL,
    Comment TEXT,
    status INT DEFAULT 0, -- 0=Pending, 1=Confirmed, 2=Cancelled
    RegDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CancelledBy ENUM('u', 'a') NULL, -- u=user, a=admin
    UpdationDate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (PackageId) REFERENCES tbltourpackages(PackageId) ON DELETE CASCADE,
    FOREIGN KEY (UserEmail) REFERENCES tblusers(EmailId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Support tickets table for user support requests
CREATE TABLE tblissues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    UserEmail VARCHAR(100) NOT NULL,
    Issue VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    AdminRemark TEXT NULL,
    PostingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AdminremarkDate TIMESTAMP NULL,
    FOREIGN KEY (UserEmail) REFERENCES tblusers(EmailId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for tour packages
INSERT INTO tbltourpackages (PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures, PackageDetails, PackageImage) VALUES
('Du lịch Đà Lạt 3N2Đ', 'Tour du lịch', 'Đà Lạt', 350.00, 'Khách sạn 3 sao, Ăn uống, Xe đưa đón', 'Khám phá thành phố ngàn hoa với các điểm đến nổi tiếng như Thung lũng Tình Yêu, Dinh Bảo Đại, Hồ Xuân Hương...', 'dalat.jpg'),
('Du lịch Nha Trang 4N3Đ', 'Tour biển', 'Nha Trang', 520.00, 'Khách sạn 4 sao, Ăn uống, Xe đưa đón, Vé tham quan', 'Trải nghiệm biển xanh, cát trắng, nắng vàng tại thành phố biển Nha Trang cùng các hoạt động vui chơi hấp dẫn...', 'nhatrang.jpg'),
('Du lịch Sa Pa 3N2Đ', 'Tour du lịch', 'Sa Pa', 420.00, 'Khách sạn 3 sao, Ăn uống, Xe đưa đón', 'Khám phá thị trấn sương mù với các điểm đến như Fansipan, bản làng người H\'Mông, ruộng bậc thang...', 'sapa.jpg'),
('Du lịch Phú Quốc 5N4Đ', 'Tour biển', 'Phú Quốc', 650.00, 'Khách sạn 5 sao, Ăn uống, Xe đưa đón, Vé tham quan', 'Trải nghiệm hòn ngọc của Việt Nam với các bãi biển tuyệt đẹp, khu vui chơi và ẩm thực đặc sản...', 'phuquoc.jpg');

-- Insert sample user data
INSERT INTO tblusers (EmailId, FullName, MobileNumber, Password, RegDate) VALUES
('admin@gmail.com', 'Nguyen Van A', '0123456789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-15 10:30:00'),
('user1@gmail.com', 'Le Thi B', '0987654321', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-02-20 14:20:00'),
('user2@gmail.com', 'Tran Van C', '0876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-03-10 09:15:00');

-- Insert sample booking data
INSERT INTO tblbooking (PackageId, UserEmail, FromDate, ToDate, Comment, status) VALUES
(1, 'user1@gmail.com', '2024-12-15', '2024-12-17', 'Yêu cầu phòng không hút thuốc', 1),
(2, 'user2@gmail.com', '2024-11-20', '2024-11-23', 'Gia đình 4 người, cần phòng lớn', 0),
(3, 'user1@gmail.com', '2024-12-01', '2024-12-03', 'Muốn đi cáp treo Fansipan', 2);

-- Insert sample support ticket data
INSERT INTO tblissues (UserEmail, Issue, Description, PostingDate) VALUES
('user1@gmail.com', 'Trễ giờ xe đón', 'Xe đón tour đi trễ 1 tiếng so với lịch hẹn', '2024-11-15 14:30:00'),
('user2@gmail.com', 'Chất lượng phòng không đúng mô tả', 'Phòng không sạch sẽ như quảng cáo, cần phản ánh', '2024-11-18 09:45:00');

-- Create indexes for better performance
CREATE INDEX idx_package_location ON tbltourpackages(PackageLocation);
CREATE INDEX idx_booking_user_email ON tblbooking(UserEmail);
CREATE INDEX idx_booking_package_id ON tblbooking(PackageId);
CREATE INDEX idx_issues_user_email ON tblissues(UserEmail);
CREATE INDEX idx_booking_date ON tblbooking(FromDate, ToDate);